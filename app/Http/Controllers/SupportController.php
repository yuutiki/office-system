<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Department;
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

class SupportController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        // $productSeriess = ProductSeries::all();  //製品シリーズ
        // $productVersions = ProductVersion::all();  //製品バージョン
        // $productCategories = ProductCategory::all();  // 製品系統
        $users = User::all();  //受付対応者用
        $supportTimes = SupportTime::all(); //サポート時間
        $supportTypes = SupportType::all();// サポート種別

        // 検索条件を取得し変数に格納
        $selectedSupportTypes = $request->input('support_types', []);
        $keywords = $request->input('keywords'); // キーワード検索
        $clientName = $request->input('client_name');


        // サポート検索クエリ
        $supportsQuery = Support::with([
            'client', 'user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->orderby('received_at', 'desc')->sortable();

        if (!empty($selectedSupportTypes)) {
            $supportsQuery->whereIn('support_type_id', $selectedSupportTypes);
        }

        // if (!empty($clientName)) {
        //     $spaceConversion = mb_convert_kana($clientName, 's');
        //     $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
        //     foreach ($wordArraySearched as $value) {
        //         Client::where('client_name', 'like', '%'.$value.'%');
        //     }
        // }

        if (!empty($clientName)) {
            // Clientモデルからclient_nameをもとにIDを取得
            $clientIds = Client::where('client_name', 'like', '%' . $clientName . '%')->pluck('id')->toArray();
        
            // 取得したIDを利用してサポート検索クエリに追加条件を設定
            if (!empty($clientIds)) {
                $supportsQuery->whereIn('client_id', $clientIds);
            }
        }

        if ($keywords) {
            $searchTextArray = Support::getSearchWordArray($keywords);
            $supportsQuery = Support::getMultiWordSearchQuery($supportsQuery, $searchTextArray);
        }

        // ページネーション設定
        $per_page = 100;
        $supports = $supportsQuery->paginate($per_page);
        $count = $supports->total(); // ページネーション後の総数を取得

        return view('support.index', compact('supports', 'count', 'supportTypes' ,'selectedSupportTypes','keywords','users','supportTimes'));
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
        $departments = Department::all();

        $clientNum = Session::get('selected_client_num');
        $clientName = Session::get('selected_client_name');

        return view('support.create',compact('users','productSeriess','productVersions','productCategories','supportTypes','supportTimes','installationTypes','clientTypes','departments','clientNum','clientName'));
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


        // 通知の内容を設定
        $notificationData = [
            'action_url' => route('support.edit', ['support' => $support->id]), // 例: サポート履歴を表示するURL
            'message' => '新しいサポート履歴が登録されました。',
            // 他の通知に関する情報をここで設定
        ];

        // 日報を登録したユーザーに通知を送信
        $user = $support->client->user_id;
        $userEigyou = User::find($user);

        // 通知の作成
        $notification = new AppNotification($support, $notificationData); // $support を通知データとして渡す

        // 通知の送信
        $this->notificationService->sendNotification($userEigyou, $notification);


        return redirect()->route('support.index')->with('message', '登録しました');
    }

    public function show(Support $support)
    {
        //
    }

    public function edit(string $id)
    {
        // $clients = Client::all();
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間

        $support = Support::find($id);


        session()->put('previous_url', url()->previous());


        return view('support.edit',compact('users','tradeStatuses','clientTypes','installationTypes','departments','support','productSeriess','productVersions','productCategories','supportTypes','supportTimes'));
    }

    public function update(Request $request, string $id)
    {

        $support = Support::find($id);
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
        $support->is_finished = $request->f_is_finished;
        $support->is_disclosured = $request->f_is_disclosured;
        $support->is_confirmed = $request->f_is_confirmed;
        $support->is_troubled = $request->f_is_troubled;
        $support->is_faq_target = $request->f_is_faq_target;
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


    public function upload(Request $request)
    {
        // ファイルがアップロードされているかチェック
        if (!$request->hasFile('csv_upload')) {
        // エラーメッセージをセットしてリダイレクト
        return redirect()->back()->with('error', 'アップロードするCSVファイルが選択されていません。');
        }

        $csvFile = $request->file('csv_upload');
        
        // CSVファイルの一時保存先パス
        $csvPath = $csvFile->getRealPath();
        
        // CSVデータのパースとデータベースへの登録処理
        $this->parseCSVAndSaveToDatabase($csvPath);

        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', 'CSVファイルをアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath)
    {
        // CSVファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset);

        $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
        $lexer = new Lexer($config);
        $interpreter = new Interpreter();

         // CSV行をパースした際に実行する処理を定義
        $interpreter->addObserver(function (array $row) {
            $support = new Support();

            $clientNum = $row[0];
                $client = Client::where('client_num', $clientNum)->first();
                if ($client) {
                    $support->client_id = $client->id;
                } else {
                    // clientが見つからない場合のエラーハンドリング
                }

            $clientId = $client->id;

            $requestNumber = Support::generateRequestNumber($clientId);
            $support->request_num = $requestNumber;

            $support->received_at = $row[1];

            $employeeNum = str_pad($row[2], 6, '0', STR_PAD_LEFT); // 6桁の顧客番号に変換してDBに保存
            // dd($employeeNum);
                $user = User::where('employee_num', $employeeNum)->first();
                if ($user) {
                    $support->user_id = $user->id;
                } else {

                }

            $support->client_user_department = $row[3];
            $support->client_user_kana_name = $row[4];

            $ProductSeriesCode = $row[5];
            $ProductSeriesId = ProductSeries::where('series_code', $ProductSeriesCode)->first();
            if ($ProductSeriesId) {
                $support->product_series_id = $ProductSeriesId->id;
            } else {

            }

            $ProductVersionCode = $row[6];
            $ProductVersionId = ProductVersion::where('version_code', $ProductVersionCode)->first();
            if ($ProductVersionId) {
                $support->product_version_id = $ProductVersionId->id;
            } else {

            }
            
            $ProductCategoryCode = $row[7];
            $ProductCategoryId = ProductCategory::where('category_code', $ProductCategoryCode)->first();
            if ($ProductCategoryId) {
                $support->product_category_id = $ProductCategoryId->id;
            } else {

            }



            $support->title = $row[8];
            $support->request_content = $row[9];
            $support->response_content = $row[10];
            // $support->proposed_payment_date = Carbon::parse($row[10] . '-01');
            $support->internal_message = $row[11];


            $support->internal_memo1 = $row[12];
            $support->is_finished = $row[13];
            $support->is_faq_target = $row[14];
            $support->is_disclosured = $row[15];
            $support->is_troubled = $row[16];
            $support->is_confirmed = $row[17];

            $supportTimeCode = $row[18];
            $supportTimeId = SupportTime::where('time_code', $supportTimeCode)->first();
            if ($supportTimeId) {
                $support->support_time_id = $supportTimeId->id;
            } else {

            }

            $supportTypeCode = $row[19];
            $supportTypeId = SupportType::where('type_code', $supportTypeCode)->first();
            if ($supportTypeId) {
                $support->support_type_id = $supportTypeId->id;
            } else {

            }
            $support->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }
}
