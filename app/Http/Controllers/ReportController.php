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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $perPage = config('constants.perPage');
        $user = User::all();
        $selectedUserId = $request->selected_user_id;

        $keywords = $request->input('keywords');

        //検索Query
        $reportQuery = Report::with('client', 'reportType', 'reporter')->sortable()->orderby('contact_at','desc');

        if (!empty($keywords)) {
            $searchTextArray = Report::getSearchWordArray($keywords);
            $reportQuery = Report::getMultiWordSearchQuery($reportQuery, $searchTextArray);
        }

        if (!empty($selectedUserId)) {
            $reportQuery->where('user_id', $selectedUserId);
        }

        $reports = $reportQuery->paginate($perPage);

        return view('reports.index',compact('reports', 'user', 'selectedUserId', 'keywords'));
    }

    public function create(Request $request)
    {
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::where('employee_status_id', 1)->get();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $selectedUserId = $request->selected_user_id;


        $clientNum = '';
        $clientName = '';
        $salesUser = '';

        return view('reports.create',compact('users', 'reportTypes', 'contactTypes', 'clientNum', 'clientName', 'salesUser', 'affiliation1s', 'affiliation2s', 'affiliation3s', 'selectedUserId'));
    }

    public function createFromClient(Client $client)
    {
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::where('employee_status_id', 1)->get();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();

        $clientNum = $client->client_num;
        $clientName = $client->client_name;
        $salesUser = $client->user->user_name;

        return view('reports.create',compact('users', 'reportTypes', 'contactTypes', 'clientNum', 'clientName', 'salesUser', 'affiliation1s', 'affiliation2s', 'affiliation3s'));
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
        $report->is_draft = $request->input('is_draft');
        $report->project_id = $request->input('project_id');
        $report->user_id = auth()->id();//ログインユーザのIDを取得

        $report->save();

        // 報告先ユーザーの設定
        $userIds = $request->input('selectedRecipientsId', []);
        if (is_array($userIds) && count($userIds) === 1) {
            // 配列の最初の要素がカンマ区切りの文字列の場合
            $userIds = explode(',', $userIds[0]);
        }

        // ユーザーIDの配列をキーとして、値にすべてfalseのis_readを持つ連想配列を作成
        $recipientData = [];
        foreach ($userIds as $userId) {
            $recipientData[$userId] = ['is_read' => false];
        }
        
        // 中間テーブルに報告先ユーザー情報を保存
        $report->recipients()->sync($recipientData);


        // 通知の内容を設定
        $notificationData = [
            'notification_title' => '新しい営業報告が登録されました。',
            'notification_body' => $report->report_title,
            'notification_type' => '0', // システム通知
            'notification_category'=> '',
            'importance'=> 0, // 通常
            'action_url' => route('reports.show', ['report' => $report->id]), // 例: 日報を表示するURL
            'source_id' => $report->id,
            'source_type' => 'report'
            // 他の通知に関する情報をここで設定
        ];

        $notificationFrom = [
            'id' => $report->reporter->id,
            'name' => $report->reporter->user_name,
            'affiliation1' => $report->reporter->affiliation1_id,
            'email' => $report->reporter->email,
            'image' =>$report->reporter->profile_image,
            // 必要に応じて他のユーザー情報を追加
        ];

        // 3. ユーザー取得結果の確認
        $users = User::whereIn('id', $userIds)->get();

        // 4. 通知データの確認
        $notification = new AppNotification($notificationData, $notificationFrom);

        // 通知の送信
        $this->notificationService->sendNotification($users, $notification);

        return redirect()->route('reports.index')->with('success','正常に登録しました');
    }

    public function show(string $id)
    {
        // レポートの取得
        $report = Report::findOrFail($id);
        $comments = $report->comments->load('user');
        $user = auth()->user();
        
        // 現在の未読通知数を取得（処理前）
        $beforeCount = $user->unreadNotifications->count();
        
        // ログインユーザーの未読通知を取得
        $unreadNotifications = $user->unreadNotifications;
        $markedAsRead = 0;
        
        // 直近の未読通知をデバッグログに記録
        if ($unreadNotifications->count() > 0) {
            Log::debug('最初の未読通知データ: ', ['data' => json_encode($unreadNotifications->first()->data)]);
        }
        
        // DBトランザクションを使用
        DB::beginTransaction();
        try {
            // 未読通知を走査して対応する通知を既読にする
            foreach ($unreadNotifications as $notification) {
                // 通知データを取得
                $notificationData = $notification->data;
                
                // notification_dataがネストされている場合
                if (isset($notificationData['notification_data'])) {
                    $sourceData = $notificationData['notification_data'];
                    
                    // source_idがレポートIDと一致するかチェック
                    if (isset($sourceData['source_id']) && (int)$sourceData['source_id'] === (int)$report->id) {
                        Log::debug('通知を既読にします: ', [
                            'notification_id' => $notification->id,
                            'report_id' => $report->id,
                            'source_id' => $sourceData['source_id']
                        ]);
                        
                        $notification->markAsRead();
                        $markedAsRead++;
                    }
                }
            }
            
            // 変更をコミット
            DB::commit();
        } catch (\Exception $e) {
            // エラー発生時はロールバック
            DB::rollBack();
            Log::error('通知の既読処理に失敗しました: ' . $e->getMessage());
        }
        
        // 処理後の最新の未読通知を再取得
        $afterCount = auth()->user()->unreadNotifications->count();
        
        // デバッグのためにログ出力
        Log::info("レポートID {$report->id} に関連する {$markedAsRead} 件の通知を既読にしました。未読通知数: {$beforeCount} → {$afterCount}");
        
        // 通知が既読になった場合、リダイレクトして画面を更新
        if ($markedAsRead > 0) {
            return redirect()->route('reports.show', ['report' => $report->id])
                        ->with('success', "{$markedAsRead}件の通知を既読にしました");
        }
        
        // 報告先ユーザーの取得
        $recipients = $report->recipients;
        
        return view('reports.show', compact('report', 'recipients', 'user', 'unreadNotifications'));
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
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $recipients = $report->recipients; // リレーションシップを使用

        return view('reports.edit',compact('users', 'report', 'reportTypes', 'contactTypes', 'recipients', 'affiliation1s', 'affiliation2s', 'affiliation3s'));
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
        $report->project_id = $request->input('project_id');
        $report->user_id = auth()->id();//ログインユーザのIDを取得
        $report->save();


        // 報告先ユーザーの更新（既存の関連を保持しつつ更新）
        $userIds = $request->input('selectedRecipientsId', []);
        if (is_array($userIds) && count($userIds) === 1) {
            $userIds = explode(',', $userIds[0]);
        }
        
        $recipientData = [];
        foreach ($userIds as $userId) {
            // 既存のレコードのis_read状態を保持するために、まず取得
            $existingRecord = $report->recipients()->where('user_id', $userId)->first();
            $isRead = $existingRecord ? $existingRecord->pivot->is_read : false;
            $readAt = $existingRecord ? $existingRecord->pivot->read_at : null;
            
            $recipientData[$userId] = [
                'is_read' => $isRead,
                'read_at' => $readAt
            ];
        }
        
        // syncメソッドで関連を更新（既存の関連を維持しつつ更新）
        $report->recipients()->sync($recipientData);


        // 選択された報告先ユーザを中間テーブルに登録
        // $selectedRecipientsId = $request->input('selectedRecipientsId');
        // $report->recipients()->attach($selectedRecipientsId);

        // 通知の内容を設定
        $notificationData = [
            'notification_title' => '営業報告が更新されました。',
            'notification_body' => $report->report_title,
            'notification_type' => '0', // システム通知
            'notification_category'=> '',
            'importance'=> 0, // 通常
            'action_url' => route('reports.show', ['report' => $report->id]), // 例: 日報を表示するURL
            'source_id' => $report->id,
            'source_type' => 'report'
            // 他の通知に関する情報をここで設定
        ];

        $notificationFrom = [
            'id' => $report->reporter->id,
            'name' => $report->reporter->user_name,
            'affiliation1' => $report->reporter->affiliation1_id,
            'email' => $report->reporter->email,
            'image' =>$report->reporter->profile_image,
            // 必要に応じて他のユーザー情報を追加
        ];

        // 3. ユーザー取得結果の確認
        $users = User::whereIn('id', $userIds)->get();

        // 4. 通知データの確認
        $notification = new AppNotification($notificationData, $notificationFrom);

        // 通知の送信
        $this->notificationService->sendNotification($users, $notification);

        return redirect()->route('reports.edit', $id)->with('success','正常に更新しました');
    }

    // 確認ボタンが押されたときのアクション
    public function markAsRead(Report $report)
    {
        // 現在のユーザーが報告先に含まれているか確認
        $userId = auth()->id();
        $recipient = $report->recipients()->where('user_id', $userId)->first();

        if (!$recipient) {
            return redirect()->back()->with('error', 'この報告の報告先ユーザーではありません。');
        }

        if ($recipient->pivot->is_read) {
            return redirect()->back()->with('info', 'すでに確認済みです。');
        }
        
        if ($recipient) {
            // 確認済みとしてマーク
            $report->recipients()->updateExistingPivot($userId, [
                'is_read' => true,
                'read_at' => now()
            ]);
            
            return redirect()->back()->with('success', '報告を確認しました');
        }
        
        return redirect()->back()->with('error', 'この報告の閲覧権限がありません');
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
