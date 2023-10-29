<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;//add
use App\Models\Client;//add
use App\Models\Comment;//add
use App\Models\ContactType;
use App\Models\Department;
use App\Models\ReportType;
use App\Notifications\AppNotification;
use App\Services\NotificationService;
use Illuminate\Pagination\Paginator;//add
use Illuminate\Notifications\DatabaseNotification;

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

        return view('report.index',compact('reports' , 'user' , 'count'));
    }

    public function create()
    {
        $departments = Department::all();
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::all();
        return view('report.create',compact('users','departments', 'reportTypes', 'contactTypes'));
    }

    public function store(Request $request)
    {
        // $rules = [
        //     'title' => 'required|max:255',
        //     'content' => 'required',
        // ];

        // $request->validate($rules);

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


        // 通知の内容を設定
        $notificationData = [
            'action_url' => route('report.show', ['report' => $report->id]), // 例: 日報を表示するURL
            'message' => '新しい日報が登録されました。',
            // 他の通知に関する情報をここで設定
        ];

        // 日報を登録したユーザーに通知を送信
        $userIds = $request->input('selectedRecipientsId',[]);
        $users = User::whereIn('id', $userIds)->get();

        // 通知の作成
        $notification = new AppNotification($report, $notificationData); // $report を通知データとして渡す

        // 通知の送信
        $this->notificationService->sendNotification($users, $notification);
  


        return redirect()->route('report.index')->with('success','正常に登録しました');
    }

    public function show($id)
    {
        $report = Report::find($id);
        $comments = $report->comments;
        return view('report.show',compact('report'));
    }

    // 顧客情報から飛ぶ画面
    public function showFromClient($id)
    {
        $report = Report::find($id);
        $comments = $report->comments;
        return view('report.show-from-client',compact('report'));
    }

    public function edit(string $id)
    {
        $report = Report::find($id);
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::all();

        // 通知を取得
        // $notificationId = $report->notification_id; // 通知IDを取得する方法は、データベース設計に依存します

        // 通知を既読にマーク
        // $notification = auth()->user()->notifications()->find($notificationId);


        // if ($notification) {
        //     $notification->markAsRead();
        // }
        
        return view('report.edit',compact('users', 'report', 'reportTypes', 'contactTypes'));
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

        return redirect()->route('report.edit', $id)->with('success','正常に更新しました');
    }

    public function destroy(string $id)
    {
        $report = Report::find($id);
        $report->delete();
        return redirect()->back()->with('message', '削除しました');
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
}
