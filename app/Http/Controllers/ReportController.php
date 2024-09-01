<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\ReportStoreRequest;
use App\Models\Affiliation3;
use App\Models\Report;
use App\Models\User;//add
use App\Models\Client;//add
use App\Models\Comment;//add
use App\Models\Affiliation1;
use App\Models\ContactType;
use App\Models\Affiliation2;
use App\Models\ReportType;
use App\Notifications\AppNotification;
use App\Services\NotificationService;
use Illuminate\Pagination\Paginator;//add
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $per_page = 25;
        $reports = Report::with('client')->sortable()->orderby('contact_at','desc')->paginate($per_page);
        $count = $reports->count();
        $user = User::all();

        return view('reports.index',compact('reports' , 'user' , 'count'));
    }

    public function create()
    {
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::where('employee_status_id', 1)->get();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();

        $clientNum = Session::get('selected_client_num');
        $clientName = Session::get('selected_client_name');
        // $clientId = Session::get('selected_client_id');

        return view('reports.create',compact('users', 'reportTypes', 'contactTypes', 'clientNum', 'clientName', 'affiliation1s', 'affiliation2s', 'affiliation3s'));
    }

    public function store(ReportStoreRequest $request)
    {
        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        $report = new Report();
        $report->client_id = $clientId;
        $report->contact_at = $request->input('contact_at');
        $report->contact_type_id = $request->input('contact_type_id');
        $report->report_type_id = $request->input('report_type_id');
        $report->report_title = $request->input('report_title');
        $report->report_content = $request->input('report_content');
        $report->report_notice = $request->input('report_notice');
        $report->client_representative = $request->input('client_representative');
        $report->user_id = auth()->id();//ログインユーザのIDを取得

        $report->save();

        $request->session()->forget('selected_client_num');
        $request->session()->forget('selected_client_name');

        // 通知の内容を設定
        $notificationData = [
            'action_url' => route('reports.show', ['report' => $report->id]), // 例: 日報を表示するURL
            'reporter' => $report->reporter->name,
            'message' => '未読の日報があります',
            'content_title' => $report->report_title,
            'source_model' => Report::class,
            'source_id' => $report->id,
            // 他の通知に関する情報をここで設定
        ];

        // 日報を登録したユーザーに通知を送信
        $userIds = $request->input('selectedRecipientsId',[]);
        $users = User::whereIn('id', $userIds)->get();

        // 通知の作成
        $notification = new AppNotification($report, $notificationData); // $report を通知データとして渡す

        // 通知の送信
        $this->notificationService->sendNotification($users, $notification);


        return redirect()->route('reports.index')->with('success','正常に登録しました');
    }

    public function show(string $id)
    {
        $report = Report::find($id);
        $comments = $report->comments;

        
    // ログインユーザーの通知を取得し、既読状態にする
    $user = auth()->user();

    // ログインユーザーの未読通知を取得
    $unreadNotifications = $user->unreadNotifications;


    // 未読通知を走査して対応する通知を既読にする
    foreach ($unreadNotifications as $notification) {
        // 通知データをデコード
        $notificationData = $notification->data;

        // 通知データから関連する報告書の情報を取得する
        $notificationReportId = $notificationData['notification_data']['source_id'];

        // 通知が特定の報告書に関連しているかチェックする
        if ($notificationReportId == $report->id) {
            // 通知が関連している場合は既読状態にする
            $notification->markAsRead();
        }
    }


        return view('reports.show',compact('report'));
    }

    // 顧客情報から飛ぶ画面
    public function showFromClient($id)
    {
        $report = Report::find($id);
        $comments = $report->comments;




        return view('reports.show-from-client',compact('report'));
    }

    public function edit(string $id)
    {
        $report = Report::find($id);
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::all();

        // // Report の通知を既読にする
        // if ($report->notification) {
        //     $this->notificationService->markAsRead($report->notification);
        // }

        
        return view('reports.edit',compact('users', 'report', 'reportTypes', 'contactTypes'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),Report::$rulesEdit);
        if ($validator->fails()) {
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $report = Report::find($id);
        $report->contact_at = $request->input('contact_at');
        $report->contact_type_id = $request->input('contact_type_id');
        $report->report_type_id = $request->input('report_type_id');
        $report->report_title = $request->input('report_title');
        $report->report_content = $request->input('report_content');
        $report->report_notice = $request->input('report_notice');
        $report->client_representative = $request->input('client_representative');
        $report->user_id = auth()->id();//ログインユーザのIDを取得
        $report->save();

        // 選択された報告先ユーザを中間テーブルに登録
        $selectedRecipientsId = $request->input('selectedRecipientsId');
        $report->recipients()->attach($selectedRecipientsId);

        return redirect()->route('reports.edit', $id)->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $report = Report::find($id);
        $report->delete();
        return redirect()->back()->with('success', '正常に削除しました');
    }

    //ユーザが報告先を選択した際に実行されるメソッド
    public function addReportToRecipient(Request $request,$userId)
    {
        $selectedRecipientsId = $request->input('selected_reports');

        if(!empty($selectedRecipientsId)){
            $user = User::find($userId);

            $user->reports()->attach($selectedRecipientsId);
        }

                // 登録後に適切なリダイレクト先にリダイレクトするなど、処理の終了を行う
        // 例えば、報告先が登録された後にユーザー詳細ページにリダイレクトする
        return redirect()->route('user.show', ['user' => $userId]);
    }


    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
        
    //     // ユーザ名、所属1、所属2、所属3のいずれかに検索クエリがマッチするユーザを取得
    //     $users = User::where('name', 'like', '%' . $query . '%')
    //                  ->orWhere('company_id', 'like', '%' . $query . '%')
    //                  ->orWhere('department_id', 'like', '%' . $query . '%')
    //                  ->orWhere('affiliation3_id', 'like', '%' . $query . '%')
    //                  ->get();
                     
    //     return view('partials.user_search_results', ['users' => $users]);
    // }

    // ユーザを検索して検索結果を返す
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', '%' . $query . '%')->get();
        // 検索結果をJSON形式で返す
        return response()->json($users);
    }

    // // 選択されたユーザを受け取り、ビューに返す（Ajaxで呼ばれる）
    // public function selectedRecipients(Request $request)
    // {
    //     $selectedUsers = $request->input('selectedUsers', []);
    //     // 必要に応じて選択されたユーザを処理する（例：データベースに保存）
    //     return response()->json(['message' => 'Success']);
    // }

    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return redirect($notification->data['url']);
    }
    
}
