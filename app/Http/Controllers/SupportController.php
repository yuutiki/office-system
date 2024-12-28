<?php

namespace App\Http\Controllers;

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
        $selectedSupportTypes = $request->input('support_types', []);
        $keywords = $request->input('keywords'); // キーワード検索
        $clientName = $request->input('client_name');
        $selectedProductCategories = $request->input('product_categories',[]);


        // サポート検索クエリ
        $supportsQuery = Support::with([
            'client', 'user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->orderby('received_at', 'desc')->sortable();

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

        if (!empty($selectedProductCategories))
        {
            $supportsQuery->whereIn('product_category_id', $selectedProductCategories);
        }

        if (!empty($keywords)) {
            $searchTextArray = Support::getSearchWordArray($keywords);
            $supportsQuery = Support::getMultiWordSearchQuery($supportsQuery, $searchTextArray);
        }

        // ページネーション設定
        $per_page = config('constants.perPage');
        $supports = $supportsQuery->paginate($per_page);
        $count = $supports->total(); // ページネーション後の総数を取得

        return view('support.index', compact('supports', 'count', 'supportTypes' ,'selectedSupportTypes','keywords','users','supportTimes','productCategories','selectedProductCategories','clientName','productVersions','productSeriess'));
    }

    public function create()
    {
        $users = User::all();  //受付対応者用
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::orderby('version_code','desc')->get();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間
        $installationTypes = InstallationType::all();
        $clientTypes = ClientType::all();
        $affiliation2s = Affiliation2::all();

        $clientNum = Session::get('selected_client_num');
        $clientName = Session::get('selected_client_name');

        return view('support.create',compact('users','productSeriess','productVersions','productCategories','supportTypes','supportTimes','installationTypes','clientTypes','affiliation2s','clientNum','clientName'));
    }

    public function store(Request $request)
    {

        // バリデーションの実行(Model)
        $validator = Validator::make($request->all(), Support::$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');
        
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        //問合せ連番を採番
        $requestNumber = Support::generateRequestNumber($clientId);

        // サポート履歴データを保存
        $support = new Support();
        $support->client_id = $clientId; // 予めclient_numから取得したclient_idをセット
        $support->request_num = $requestNumber;// 採番した問合せ連番をセット
        $support->received_at = $request->f_received_at;
        $support->title = $request->f_title;
        $support->request_content = $request->f_request_content;
        $support->response_content = $request->f_response_content;
        $support->internal_message = $request->f_internal_message;
        $support->internal_memo1 = $request->f_internal_memo1;
        $support->support_type_id = $request->f_support_type_id;
        $support->support_time_id = $request->f_support_time_id;
        $support->user_id = $request->f_user_id;// 受付対応者
        $support->client_user_department = $request->f_client_user_department;
        $support->client_user_kana_name = $request->f_client_user_kana_name;
        $support->product_series_id = $request->f_product_series_id;
        $support->product_version_id = $request->f_product_version_id;
        $support->product_category_id = $request->f_product_category_id;
        $support->is_finished = $request->has('f_is_finished') ? 1 : 0;
        $support->is_disclosured = $request->has('f_is_disclosured') ? 1 : 0;
        $support->is_confirmed = $request->has('f_is_confirmed') ? 1 : 0;
        $support->is_troubled = $request->has('f_is_troubled') ? 1 : 0;
        $support->is_faq_target = $request->has('f_is_faq_target') ? 1 : 0;
        $support->save();

        $request->session()->forget('selected_client_num');
        $request->session()->forget('selected_client_name');


        // // 通知の内容を設定
        // $notificationData = [
        //     'action_url' => route('support.edit', ['support' => $support->id]), // 例: サポート履歴を表示するURL
        //     'reporter' => $support->user->user_name,
        //     'message' => '新しいサポート履歴が登録されました。',
        //     // 他の通知に関する情報をここで設定
        // ];

        // 通知の内容を設定
        $notificationData = [
            'notification_title' => '新しいサポート履歴が登録されました。',
            'notification_body' => $support->title,
            'notification_type' => '0', // システム通知
            'notification_category'=> '',
            'importance'=> 0, // 通常
            'action_url' => route('support.edit', ['support' => $support->id]),// 例: 日報を表示するURL
            // 他の通知に関する情報をここで設定
        ];

        $notificationFrom = [
            'id' => $support->user->id,
            'name' => $support->user->user_name,
            'affiliation1' => $support->user->affiliation1_id,
            'email' => $support->user->email,
            'image' =>$support->user->profile_image,
            // 必要に応じて他のユーザー情報を追加
        ];

        // 日報を登録したユーザーに通知を送信
        $user = $support->client->user_id;
        $userEigyou = User::find($user);

        // 通知の作成
        $notification = new AppNotification($notificationData, $notificationFrom); // $support を通知データとして渡す

        // 通知の送信
        $this->notificationService->sendNotification($userEigyou, $notification);


        return redirect()->route('support.index')->with('message', '登録しました');
    }

    public function show(Support $support)
    {
        //
    }

    public function edit(Support $support)
    {
        // $clients = Client::all();
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $affiliation2s = Affiliation2::all();
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間

        $support = Support::find($support->id);
        $clientId = $support->client_id;

        // $client = Client::findOrFail($clientId);

        // $clientSystems = $client->products;

        // 特定のクライアントを取得
        $client = Client::findOrFail($clientId);

        // クライアントに関連する製品を取得
        $clientProducts = ClientProduct::where('client_id', $clientId)->get();


        session()->put('previous_url', url()->previous());


        return view('support.edit',compact('users','tradeStatuses','clientTypes','installationTypes','affiliation2s','support','productSeriess','productVersions','productCategories','supportTypes','supportTimes', 'clientProducts',));
    }

    public function update(Request $request, string $id)
    {

        // // バリデーションルール
        // $rules = [
        //     'received_at' => 'required', 
        // ];

        // // バリデーション実行
        // $validator = Validator::make($request->all(), $rules);
        // // バリデーションエラーがある場合
        // if ($validator->fails()) {
        //     session()->flash('error', '入力内容にエラーがあります。');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // $support = Support::find($id);
        // $support->received_at = $request->f_received_at;
        // $support->title = $request->f_title;
        // $support->request_content = $request->f_request_content;
        // $support->response_content = $request->f_response_content;
        // $support->internal_message = $request->f_internal_message;
        // $support->internal_memo1 = $request->f_internal_memo1;
        // $support->support_type_id = $request->f_support_type_id;
        // $support->support_time_id = $request->f_support_time_id;
        // $support->user_id = $request->f_user_id;// 受付対応者
        // $support->client_user_department = $request->f_client_user_department;
        // $support->client_user_kana_name = $request->f_client_user_kana_name;
        // $support->product_series_id = $request->f_product_series_id;
        // $support->product_version_id = $request->f_product_version_id;
        // $support->product_category_id = $request->f_product_category_id;
        // $support->is_finished = $request->f_is_finished;
        // $support->is_disclosured = $request->f_is_disclosured;
        // $support->is_confirmed = $request->f_is_confirmed;
        // $support->is_troubled = $request->f_is_troubled;
        // $support->is_faq_target = $request->f_is_faq_target;
        // $support->save();

        $support = Support::find($id);
        $support->received_at = $request->input('received_at_' . $id);
        $support->title = $request->input('title_' . $id);
        $support->request_content = $request->input('request_content_' . $id);
        $support->response_content = $request->input('response_content_' . $id);
        $support->internal_message = $request->input('internal_message_' . $id);
        $support->internal_memo1 = $request->input('internal_memo1_' . $id);
        $support->support_type_id = $request->input('support_type_id_' . $id);
        $support->support_time_id = $request->input('support_time_id_' . $id);
        $support->user_id = $request->input('user_id_' . $id);// 受付対応者
        $support->client_user_department = $request->input('client_user_department_' . $id);
        $support->client_user_kana_name = $request->input('client_user_kana_name_' . $id);
        $support->product_series_id = $request->input('product_series_id_' . $id);
        $support->product_version_id = $request->input('product_version_id_' . $id);
        $support->product_category_id = $request->input('product_category_id_' . $id);
        $support->is_finished = $request->input('is_finished_' . $id);
        $support->is_disclosured = $request->input('is_disclosured_' . $id);
        $support->is_confirmed = $request->input('is_confirmed_' . $id);
        $support->is_troubled = $request->input('is_troubled_' . $id);
        $support->is_faq_target = $request->input('is_faq_target_' . $id);
        $support->save();

        return redirect()->route('support.index')->with('success', '変更しました');
    }

    public function destroy(string $id)
    {
        $support = Support::find($id);
        // $projectId = $projectRevenue->project->id;
        $support->delete();

        // return redirect()->route('project.edit', $projectId)->with('message', '削除しました');
        return redirect()->back()->with('success', '正常に削除しました');

    }

    //モーダル用の非同期検索ロジック
    // public function search(Request $request)
    // {
    //     $clientName = $request->input('clientName');
    //     $clientNumber = $request->input('clientNumber');

    //     // 検索条件に基づいて顧客データを取得
    //     $clients = Client::where('client_name', 'LIKE', '%' . $clientName . '%')
    //         ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
    //         ->get();

    //     return response()->json($clients);
    // }

    public function showUploadForm()
    {
        return view('support.upload-form');
    }


    public function upload(Request $request)
    {
        try {
            $request->validate([
                'csv_upload' => 'required|file|mimes:csv,txt|max:10240',
            ]);

            $file = $request->file('csv_upload');
            $originalName = $file->getClientOriginalName();
            $tempFilePath = $this->saveTempFile($file);

            $import = new SupportsImport($tempFilePath);
            Excel::import($import, $tempFilePath);

            $results = $this->getImportResults($import);
            $this->logImportResults($results, $originalName);

            return $this->handleSuccessfulImport($results, $originalName);
        } catch (LaravelValidationException $e) {
            Log::error("File Validation Error: " . $e->getMessage());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'ファイルのバリデーションに失敗しました。');
        } catch (ValidationException $e) {
            Log::error("CSV Validation Error: " . $e->getMessage());
            $errors = $this->formatValidationErrors($e->failures());
            return $this->handleValidationError($errors, $originalName);
        } catch (\Exception $e) {
            Log::error("CSV Import Error: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            return $this->handleGeneralError($e, $originalName);
        } finally {
            if (isset($tempFilePath) && file_exists($tempFilePath)) {
                $this->deleteTempFile($tempFilePath);
            }
        }
    }

    private function saveTempFile($file)
    {
        $tempFileName = 'temp_csv_file_' . time() . '.csv';
        $tempFilePath = storage_path('app/temp/' . $tempFileName);
        
        if (!Storage::disk('local')->put('temp/' . $tempFileName, file_get_contents($file->getRealPath()))) {
            throw new \Exception("ファイルの一時保存に失敗しました。");
        }

        return $tempFilePath;
    }

    private function deleteTempFile($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function getImportResults($import)
    {
        return [
            'totalRows' => $import->getRowCount(),
            'successRows' => $import->getSuccessCount(),
            'skippedRows' => count($import->getErrors()),
        ];
    }

    private function logImportResults($results, $originalName)
    {
        $message = "CSVファイル '{$originalName}' のインポート結果:\n" .
                   "処理行数: {$results['totalRows']}, " .
                   "成功: {$results['successRows']}, " .
                   "スキップ: {$results['skippedRows']}";
        Log::info($message);
    }

    private function handleSuccessfulImport($results, $originalName)
    {
        $successMessage = "CSVファイル '{$originalName}' のインポートが完了しました。";
        $detailMessage = "処理行数: {$results['totalRows']}, 成功: {$results['successRows']}, スキップ: {$results['skippedRows']}";

        return redirect()->back()
            ->with('success', $successMessage)
            ->with('success_details', $detailMessage);
    }

    private function handleValidationError($errors, $originalName)
    {
        $errorMessage = "CSVファイル '{$originalName}' のバリデーションに失敗しました。";
        
        return redirect()->back()
            ->with('error', $errorMessage)
            ->with('validation_errors', $errors);
    }

    private function handleGeneralError($e, $originalName)
    {
        $errorMessage = "CSVファイル '{$originalName}' のインポートに失敗しました: " . $e->getMessage();
        
        return redirect()->back()
            ->with('error', $errorMessage);
    }

    private function formatValidationErrors($failures)
    {
        $errors = [];
        foreach ($failures as $failure) {
            $row = $failure->row();
            $attribute = $failure->attribute();
            $columnName = $this->getColumnName($attribute);
            foreach ($failure->errors() as $error) {
                $errors[] = "{$row}行目 {$columnName}列: {$error}";
            }
        }
        return $errors;
    }

private function getColumnName($attribute)
{
    $columnNames = [
        '0' => '顧客番号',
        '1' => '受付日',
        '2' => '社員番号',
        '3' => '担当者部署',
        '4' => '担当者名',
        '5' => 'シリーズ',
        '6' => 'バージョン',
        '7' => '系統',
        '8' => '表題',
        '9' => '内容',
        '10' => '回答',
        '11' => '社内連絡欄',
        '12' => '社内メモ欄',
        '13' => '対応完了済',
        '14' => 'FAQ対象',
        '15' => '顧客開示',
        '16' => 'トラブル',
        '17' => '入力確認',
        '18' => '所要時間コード',
        '19' => '種別コード',
    ];

    return $columnNames[$attribute] ?? $attribute . '列';
}
}
