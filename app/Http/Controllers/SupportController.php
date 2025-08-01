<?php
namespace App\Http\Controllers;

use App\Http\Requests\Support\SupportStoreRequest;
use App\Http\Requests\Support\SupportUpdateRequest;
use App\Models\Affiliation2;
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\ClientType;
use App\Models\InstallationType;
use App\Models\ProductCategory;
use App\Models\ProductSeries;
use App\Models\ProductVersion;
use App\Models\Support;
use App\Models\SupportTime;
use App\Models\SupportType;
use App\Models\TradeStatus;
use App\Models\User;
use App\Notifications\AppNotification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use App\Imports\SupportsImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException as LaravelValidationException;

set_time_limit(60);

class SupportController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        // 検索条件用
        $productSeriess = ProductSeries::select('id', 'series_name')->get();  //製品シリーズ
        $productVersions = ProductVersion::select('id', 'version_name')->get();  //製品バージョン
        $productCategories = ProductCategory::select('id', 'category_name')->get();  // 製品系統
        $users = User::select('id', 'user_name')->get();  //受付対応者用
        $supportTimes = SupportTime::select('id', 'time_name')->get(); //サポート時間
        $supportTypes = SupportType::select('id', 'type_name')->get();// サポート種別


        // 検索リクエストを取得し変数に格納
        $keywords = $request->input('keywords'); // キーワード検索
        $clientName = $request->input('client_name');
        $selectedSupportTypes = $request->input('support_types', []);
        $selectedProductCategories = $request->input('product_categories',[]);
        $selectedProductSeriess = $request->input('product_seriess', []);
        $statusIds = $request->input('status_ids', []);
        $selectedUserId = $request->input('selected_user_id');
        $receivedAtFrom = $request->input('received_at_from');
        $receivedAtTo = $request->input('received_at_to');

        // 選択されたユーザーをオブジェクトでViewに返す
        $selectedUser = null;
        if ($selectedUserId) {
            $selectedUser = User::find($selectedUserId);
        }


        // サポート検索クエリ
        $supportsQuery = Support::with([
            'client', 'user', 'client.user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->sortable('received_at', 'desc');


        // 現在ログインしているユーザーのIDを取得
        $loggedInUserId = Auth::id();

        // is_draft = 1のデータはログインユーザーのものだけ表示
        $supportsQuery->where(function($query) use ($loggedInUserId) {
            // 下書きでないデータすべて
            $query->where('is_draft', 0)
                // または、ログインユーザーの下書きデータ
                ->orWhere(function($q) use ($loggedInUserId) {
                    $q->where('is_draft', 1)
                        ->where('user_id', $loggedInUserId);
                });
        });

        if (!empty($selectedSupportTypes)) {
            $supportsQuery->whereIn('support_type_id', $selectedSupportTypes);
        }

        if (!empty($clientName)) {
            // Clientモデルからclient_nameをもとにIDを取得
            $clientIds = Client::where('client_name', 'like', '%' . $clientName . '%')->pluck('id')->toArray();
        
            // 取得したIDを利用してサポート検索クエリに追加条件を設定
            if (!empty($clientIds)) {
                $supportsQuery->whereIn('client_id', $clientIds);
            }
        }

        if (!empty($statusIds))
        {
            $supportsQuery->whereIn('is_draft', $statusIds);
        }

        if (!empty($selectedProductCategories))
        {
            $supportsQuery->whereIn('product_category_id', $selectedProductCategories);
        }

        if (!empty($selectedProductSeriess)) {
            $supportsQuery->whereIn('product_series_id', $selectedProductSeriess);
        }

        if (!empty($selectedUserId)) {
            $supportsQuery->where('user_id', $selectedUserId);
        }

        if (!empty($receivedAtFrom) && !empty($receivedAtTo)) {
            $supportsQuery->whereBetween('received_at', [$receivedAtFrom, $receivedAtTo]);
        }

        if (!empty($keywords)) {
            $searchTextArray = Support::getSearchWordArray($keywords);
            $supportsQuery = Support::getMultiWordSearchQuery($supportsQuery, $searchTextArray);
        }

        // ページネーション設定
        $perPage = config('constants.perPage');
        $supports = $supportsQuery->paginate($perPage);
        $count = $supports->total(); // ページネーション後の総数を取得

        return view('supports.index', compact('supports', 'count', 'supportTypes', 'selectedSupportTypes', 'keywords', 'users', 'supportTimes', 'productCategories', 'selectedProductCategories', 'selectedProductSeriess', 'clientName', 'productVersions', 'productSeriess', 'selectedUserId' ,'selectedUser', 'receivedAtFrom', 'receivedAtTo', 'statusIds'));
    }

    public function create()
    {
        $users = User::all();  //受付対応者用
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::orderby('version_code','desc')->get();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統

        $affiliation2s = Affiliation2::all();
        $client = null;

        return view('supports.create', compact('users', 'supportTypes', 'supportTimes', 'productSeriess', 'productVersions', 'productCategories', 'affiliation2s', 'client'));
    }

    public function createFromClient(Client $client)
    {
        $users = User::all();  //受付対応者用
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::orderby('version_code','desc')->get();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統

        $affiliation2s = Affiliation2::all();

        return view('supports.create', compact('users', 'supportTypes', 'supportTimes', 'productSeriess', 'productVersions', 'productCategories', 'affiliation2s', 'client'));
    }

    public function store(SupportStoreRequest $request)
    {
        // サポート履歴データを作成
        $support = Support::createSupport($request->validated());

        // 通知の内容を設定
        $notificationData = [
            'notification_title' => '新しいサポート履歴が登録されました。',
            'notification_body' => $support->title,
            'notification_type' => '0', // システム通知
            'notification_category'=> '',
            'importance'=> 0, // 通常
            'action_url' => route('supports.edit', ['support' => $support->id]),// 例: 日報を表示するURL
            // 他の通知に関する情報をここで設定
        ];

        // 通知の送信元を設定
        $notificationFrom = [
            'id' => $support->user->id,
            'name' => $support->user->user_name,
            'affiliation1' => $support->user->affiliation1_id,
            'email' => $support->user->email,
            'image' =>$support->user->profile_image,
            // 必要に応じて他のユーザー情報を追加
        ];

        // 通知の送信先を設定（顧客の営業担当）
        $clientSalesUser = User::find($support->client->user_id);

        // 通知の作成
        $notification = new AppNotification($notificationData, $notificationFrom);

        // 通知の送信
        $this->notificationService->sendNotification($clientSalesUser, $notification);

        if($request->is_draft) {
            return redirect()->route('supports.index')->with('success', '正常に一時保存しました');
        }else {
            return redirect()->route('supports.index')->with('success', '正常に登録しました');
        }
    }

    public function show(Support $support)
    {
        //
    }

    public function edit(Support $support)
    {
        $users = User::all();
        $affiliation2s = Affiliation2::all();
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間

        $support = Support::find($support->id);
        $clientId = $support->client_id;

        // 特定のクライアントを取得
        $client = Client::findOrFail($clientId);

        // クライアントに関連する製品を取得
        $clientProducts = ClientProduct::where('client_id', $clientId)->get();


        session()->put('previous_url', url()->previous());

        return view('supports.edit',compact('users', 'affiliation2s', 'support', 'productSeriess', 'productVersions', 'productCategories', 'supportTypes', 'supportTimes', 'clientProducts',));
    }

    public function update(SupportUpdateRequest $request, string $id)
    {
        // Formrequestでバリデーション
        // Modelで更新処理
        // tryで存在確認、エラー時はリダイレクトしてerrorメッセージ出す

        $support = Support::findOrFail($id);
        $support->received_at = $request->received_at;
        $support->title = $request->title;
        $support->is_draft = $request->is_draft;
        $support->request_content = $request->request_content;
        $support->response_content = $request->response_content;
        $support->internal_message = $request->internal_message;
        $support->internal_memo1 = $request->internal_memo1;
        $support->support_type_id = $request->support_type_id;
        $support->support_time_id = $request->support_time_id;
        $support->user_id = $request->user_id;// 受付対応者
        $support->client_user_department = $request->client_user_department;
        $support->client_user_kana_name = $request->client_user_kana_name;
        $support->product_series_id = $request->product_series_id;
        $support->product_version_id = $request->product_version_id;
        $support->product_category_id = $request->product_category_id;
        $support->is_finished = $request->is_finished;
        $support->is_disclosured = $request->is_disclosured;
        $support->is_confirmed = $request->is_confirmed;
        $support->is_troubled = $request->is_troubled;
        $support->is_faq_target = $request->is_faq_target;
        $support->save();

        // $support = Support::find($id);
        // $support->received_at = $request->input('received_at_' . $id);
        // $support->title = $request->input('title_' . $id);
        // $support->request_content = $request->input('request_content_' . $id);
        // $support->response_content = $request->input('response_content_' . $id);
        // $support->internal_message = $request->input('internal_message_' . $id);
        // $support->internal_memo1 = $request->input('internal_memo1_' . $id);
        // $support->support_type_id = $request->input('support_type_id_' . $id);
        // $support->support_time_id = $request->input('support_time_id_' . $id);
        // $support->user_id = $request->input('user_id_' . $id);// 受付対応者
        // $support->client_user_department = $request->input('client_user_department_' . $id);
        // $support->client_user_kana_name = $request->input('client_user_kana_name_' . $id);
        // $support->product_series_id = $request->input('product_series_id_' . $id);
        // $support->product_version_id = $request->input('product_version_id_' . $id);
        // $support->product_category_id = $request->input('product_category_id_' . $id);
        // $support->is_finished = $request->input('is_finished_' . $id);
        // $support->is_disclosured = $request->input('is_disclosured_' . $id);
        // $support->is_confirmed = $request->input('is_confirmed_' . $id);
        // $support->is_troubled = $request->input('is_troubled_' . $id);
        // $support->is_faq_target = $request->input('is_faq_target_' . $id);
        // $support->save();

        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(string $id)
    {
        $support = Support::find($id);
        $support->delete();

        return redirect()->route('supports.index')->with('success', '正常に削除されました');            
    }

    public function showUploadForm()
    {
        return view('supports.upload-form');
    }













    

    public function upload(Request $request)
    {
        // 処理時間とメモリの制限を60秒に設定
        set_time_limit(60);
        ini_set('memory_limit', '512M');
        
        $tempFilePath = null;
        
        try {
            $request->validate([
                'csv_upload' => 'required|file|mimes:csv,txt|max:10240',
            ]);
    
            $file = $request->file('csv_upload');
            $originalName = $file->getClientOriginalName();
            
            // 一時ファイルの保存
            $tempFilePath = $this->saveTempFile($file);
    
            // インポート実行
            DB::beginTransaction();
            
            try {
                $import = new SupportsImport($tempFilePath);
                Excel::import($import, $tempFilePath);
                
                if ($import->hasErrors()) {
                    DB::rollBack();
                    
                    return redirect()->back()
                        ->with('error', "インポート中にエラーが発生しました。")
                        ->with('validation_errors', $this->formatDetailedErrors($import->getErrors()));
                }
                
                DB::commit();
                
                $results = [
                    'totalRows' => $import->getRowCount(),
                    'successRows' => $import->getSuccessCount(),
                    'errorCount' => count($import->getErrors()),
                ];
                
                $this->logImportResults($results, $originalName);
                return $this->handleSuccessfulImport($results, $originalName);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Import transaction error: " . $e->getMessage());
                return redirect()->back()
                    ->with('error', "インポートに失敗しました: " . $e->getMessage());
            }
    
        } catch (\Exception $e) {
            Log::error("CSV Import Error: " . $e->getMessage());
            return redirect()->back()
                ->with('error', "エラーが発生しました: " . $e->getMessage());
        } finally {
            // 一時ファイルの削除
            if ($tempFilePath && file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }
            
            // メモリ制限を元に戻す
            ini_restore('memory_limit');
        }
    }
    
    private function saveTempFile($file)
    {
        $mimeType = $file->getMimeType();
        
        if (!in_array($mimeType, ['text/csv', 'text/plain', 'application/csv'])) {
            throw new \Exception("不正なファイル形式です。CSVファイルをアップロードしてください。");
        }
        
        $tempFileName = 'temp_csv_' . uniqid() . '.csv';
        $tempDir = storage_path('app/temp');
        
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        $tempFilePath = $tempDir . '/' . $tempFileName;
        $file->move($tempDir, $tempFileName);
        
        return $tempFilePath;
    }
    
    private function formatDetailedErrors($errors)
    {
        $formattedErrors = [];
        
        foreach ($errors as $error) {
            $row = $error['row'] ?? '不明';
            $message = $error['message'] ?? '不明なエラー';
            
            // 行番号を実際のCSV行番号に変換（ヘッダーを除く）
            $actualRow = is_numeric($row) ? $row - 1 : $row;
            $formattedErrors[] = "{$actualRow}行目: {$message}";
        }
        
        return array_unique($formattedErrors);
    }
    
    private function logImportResults($results, $originalName)
    {
        $message = sprintf(
            "CSVインポート完了 [%s] - 処理行数: %d, 成功: %d, エラー: %d",
            $originalName,
            $results['totalRows'],
            $results['successRows'],
            $results['errorCount']
        );
        Log::info($message);
    }
    
    private function handleSuccessfulImport($results, $originalName)
    {
        $successMessage = "CSVファイル '{$originalName}' のインポートが完了しました。";
        $detailMessage = sprintf(
            "処理行数: %d, 成功: %d, エラー: %d",
            $results['totalRows'],
            $results['successRows'],
            $results['errorCount']
        );
    
        return redirect()->back()
            ->with('success', $successMessage)
            ->with('success_details', $detailMessage);
    }
}
