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
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $per_page = config('constants.perPage');
        // $reports = Report::with('client', 'user')->sortable()->orderby('contact_at','desc')->paginate($per_page);
        $user = User::all();
        $selectedUserId = $request->selected_user_id;

        //検索Query
        $reportQuery = Report::with('client')->sortable()->orderby('contact_at','desc');

        if (!empty($selectedUserId)) {
            $reportQuery->where('user_id', $selectedUserId);
        }

        $reports = $reportQuery->paginate($per_page);
        $count = $reports->count();


        return view('reports.index',compact('reports' , 'user' , 'count', 'selectedUserId'));
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

    // 1. 受け取った値の確認
    \Log::info('Received userIds:', [
        'raw' => $request->input('selectedRecipientsId'),
        'type' => gettype($request->input('selectedRecipientsId'))
    ]);

    // 修正後:
    $userIds = $request->input('selectedRecipientsId', []);
    if (is_array($userIds) && count($userIds) === 1) {
        // 配列の最初の要素がカンマ区切りの文字列の場合
        $userIds = explode(',', $userIds[0]);
    }
    \Log::info('User IDs after processing:', ['userIds' => $userIds]);

    // 3. ユーザー取得結果の確認
    $users = User::whereIn('id', $userIds)->get();
    \Log::info('Retrieved users:', [
        'count' => $users->count(),
        'users' => $users->pluck('id')->toArray()
    ]);

    // 4. 通知データの確認
    $notification = new AppNotification($report, $notificationData);
    \Log::info('Notification data:', [
        'report_id' => $report->id,
        'notification_data' => $notificationData
    ]);

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



        $notifiableIds = DatabaseNotification::query()
        ->where('data->notification_data->source_model', 'App\\Models\\Report')
        ->where('data->notification_data->source_id', $id)
        ->pluck('notifiable_id')
        ->all();

        // dd($notifiableIds);

        $recipients = User::whereIn('id', $notifiableIds)->get();


        return view('reports.show',compact('report', 'recipients'));
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



        
        return view('reports.edit',compact('users', 'report', 'reportTypes', 'contactTypes',));
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
