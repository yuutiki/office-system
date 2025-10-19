<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\ReportStoreRequest;
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
use App\Http\Requests\Report\ReportUpdateRequest;
use App\Models\Notification;
use App\Services\PaginationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index(Request $request, PaginationService $paginationService)
    {
        $perPage = $paginationService->getPerPage($request);
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
        $selectedUserId = $request->selected_user_id;


        $clientNum = '';
        $clientName = '';
        $salesUser = '';

        return view('reports.create',compact('users', 'reportTypes', 'contactTypes', 'clientNum', 'clientName', 'salesUser', 'affiliation1s', 'affiliation2s', 'selectedUserId'));
    }

    public function createFromClient(Client $client)
    {
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::where('employee_status_id', 1)->get();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();

        $clientNum = $client->client_num;
        $clientName = $client->client_name;
        $salesUser = $client->user->user_name;

        return view('reports.create',compact('users', 'reportTypes', 'contactTypes', 'clientNum', 'clientName', 'salesUser', 'affiliation1s', 'affiliation2s'));
    }



    public function store(ReportStoreRequest $request)
    {
        // バリデーション済データを取得
        $validated = $request->validated();

        // selectedRecipientsId はDB保存対象外のため除外
        $recipients = $validated['selectedRecipientsId'] ?? [];
        unset($validated['selectedRecipientsId']);

        // 顧客担当者IDを取り出して別処理へ
        $clientContactIds = $request->input('client_contact_ids', []);

        // fillで一括代入（fillableに登録済み項目のみ）
        $report = new Report();
        $report->fill($validated);
        $report->user_id = Auth::id();
        $report->save();

        // ===============================
        // ✅ 顧客担当者との紐づけ（多対多）
        // ===============================
        if (is_array($clientContactIds) && count($clientContactIds) === 1) {
            // JS側からカンマ区切りで来る場合に対応
            $clientContactIds = explode(',', $clientContactIds[0]);
        }
        $report->clientContacts()->sync($clientContactIds);

        // ===============================
        // ✅ 報告先ユーザー設定（既存ロジック）
        // ===============================
        if (is_array($recipients) && count($recipients) === 1) {
            $recipients = explode(',', $recipients[0]);
        }

        $recipientData = [];
        foreach ($recipients as $recipient) {
            $recipientData[$recipient] = ['is_read' => false];
        }
        $report->recipients()->sync($recipientData);

        // 通知処理（既存ロジックそのまま）
        $notificationData = [
            'notification_title' => '新しい営業報告が登録されました。',
            'notification_body' => $report->report_title,
            'notification_type' => '0',
            'notification_category'=> '',
            'importance'=> 0,
            'action_url' => route('reports.show', ['report' => $report->id]),
            'source_id' => $report->id,
            'source_type' => 'report'
        ];

        $notificationFrom = [
            'id' => $report->reporter->id,
            'name' => $report->reporter->user_name,
            'affiliation1' => $report->reporter->affiliation1_id,
            'email' => $report->reporter->email,
            'image' =>$report->reporter->profile_image,
        ];

        $users = User::whereIn('id', $recipients)->get();
        $notification = new AppNotification($notificationData, $notificationFrom);
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
    // public function showFromClient($id)
    // {
    //     $report = Report::find($id);
    //     $comments = $report->comments;

    //     return view('reports.show-from-client',compact('report'));
    // }

    public function edit(string $id)
    {
        // Eager Loadingを追加して、関連データを効率的に取得
        $report = Report::with(['client', 'project', 'clientContacts', 'reporter', 'recipients'])->find($id);
        $reportTypes = ReportType::all();
        $contactTypes = ContactType::all();
        $users = User::all();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $recipients = $report->recipients;

        return view('reports.edit', compact('users', 'report', 'reportTypes', 'contactTypes', 'recipients', 'affiliation1s', 'affiliation2s'));
    }

    public function update(ReportUpdateRequest $request, Report $report)
    {
        DB::transaction(function () use ($request, $report) {
            // ✅ バリデーション済みデータを取得
            $validated = $request->validated();

            // 保存対象外データを分離
            $recipients = $validated['selectedRecipientsId'] ?? [];
            unset($validated['selectedRecipientsId']);

            // 顧客担当者IDの取得
            $clientContactIds = $request->input('client_contact_ids', []);
            if (is_array($clientContactIds) && count($clientContactIds) === 1) {
                $clientContactIds = explode(',', $clientContactIds[0]);
            }

            // 空の値を除外(文字列として保持)
            $clientContactIds = array_filter(
                array_map('trim', (array)$clientContactIds),
                fn($id) => !empty($id)
            );

            // ✅ 基本情報更新
            $report->fill($validated);
            $report->save();

            // ✅ 顧客担当者リレーション更新
            $report->clientContacts()->sync($clientContactIds);


            // ✅ 報告先ユーザー更新
            if (is_array($recipients) && count($recipients) === 1) {
                $recipients = explode(',', $recipients[0]);
            }

            // 空の値を除外して整数化
            $recipients = array_filter(array_map('intval', (array)$recipients));

            $recipientData = [];
            foreach ($recipients as $recipient) {
                $recipientData[$recipient] = ['is_read' => false];
            }
            $report->recipients()->sync($recipientData);

            // ✅ 通知処理（更新通知）
            $notificationData = [
                'notification_title' => '営業報告が更新されました。',
                'notification_body'  => $report->report_title,
                'notification_type'  => '0',
                'notification_category'=> '',
                'importance'         => 0,
                'action_url'         => route('reports.show', ['report' => $report->id]),
                'source_id'          => $report->id,
                'source_type'        => 'report'
            ];

            $notificationFrom = [
                'id'          => $report->reporter->id,
                'name'        => $report->reporter->user_name,
                'affiliation1'=> $report->reporter->affiliation1_id,
                'email'       => $report->reporter->email,
                'image'       => $report->reporter->profile_image,
            ];

            $users = User::whereIn('id', $recipients)->get();
            $notification = new AppNotification($notificationData, $notificationFrom);
            $this->notificationService->sendNotification($users, $notification);
        });

        return redirect()->route('reports.edit', $report->id)->with('success', '正常に更新しました');
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


    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return redirect($notification->data['url']);
    }
}
