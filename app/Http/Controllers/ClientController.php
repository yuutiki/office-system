<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Corporation;//add
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\User;
use App\Models\Affiliation2;//add
use App\Models\ClientSearchModalDisplayItem;
use App\Models\InstallationType;//add
use App\Models\ClientType;//add
use App\Models\DistributionType;
use App\Models\TradeStatus;//add
use App\Models\Prefecture;//add
use App\Models\Report;//add
use App\Models\Support;
use App\Utils\PostCodeUtils;
use Illuminate\Http\Request;
use Illuminate\pagination\paginator;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');
        $selectedUserId = $request->selected_user_id;

        // 現在のログインユーザを取得
                // @var User $loggedInUser
        $loggedInUser = Auth::user();

        // UserモデルのisSystemAdmin()メソッドを呼び出す
        if ($loggedInUser && $loggedInUser->role ==  config('sytemadmin.system_admin')) {
            // システム管理者を含む全てのユーザーを取得
            $salesUsers = User::all();
        } else {
            // システム管理者を除くユーザーを取得
            $salesUsers = User::where('role', '!=', config('sytemadmin.system_admin'))->get();
        }

        $affiliation2s = Affiliation2::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();

        // ログインユーザーの所属を取得
        $userAffiliation2 = auth()->user()->affiliation2_id;
        $selectedAffiliation2 = $userAffiliation2; // ユーザーの所属を初期値に設定

        // 検索リクエストを取得し変数に格納
        $request->session()->put([
            'user_id' => $request->user_id,
        ]);
        $selectedTradeStatuses = $request->input('trade_statuses', []);
        $selectedClientTypes = $request->input('client_types', []);
        $selectedInstallationTypes = $request->input('installation_types', []);
        $clientName = $request->input('client_name');
        $salesUserId = $request->input('selected_user_id');
        $affiliation2Id = $request->input('affiliation2_id');

        // 検索クエリを組み立てる
        $clientsQuery = Client::with(['corporation','user','tradeStatus','affiliation2'])->sortable()->orderBy('client_num','asc');

        if (!empty($selectedTradeStatuses)) {// 取引状態
            $clientsQuery->whereIn('trade_status_id', $selectedTradeStatuses);
        }
        if (!empty($selectedClientTypes)) {// 顧客種別
            $clientsQuery->whereIn('client_type_id', $selectedClientTypes);
        }
        if (!empty($selectedInstallationTypes)) {// 設置種別
            $clientsQuery->whereIn('installation_type_id', $selectedInstallationTypes);
        }
        if (!empty($salesUserId)) {
            $clientsQuery->where('user_id', $salesUserId);
        }
        if (!empty($clientName)) {
            // Clientモデルからclient_nameをもとにIDを取得
            $clientsQuery = Client::where('client_name', 'like', '%' . $clientName . '%');
        }
        // if (!empty($clientName)) {
        //     // Clientモデルからclient_nameをもとにIDを取得
        //     $clientIds = Client::where('client_name', 'like', '%' . $clientName . '%')->pluck('id')->toArray();
        
        //     // 取得したIDを利用してサポート検索クエリに追加条件を設定
        //     if (!empty($clientIds)) {
        //         $clientsQuery->whereIn('id', $clientIds);
        //     }
        // }




        // 初期表示で絞る
        // if (empty($salesUserId)) {
        //     $clientsQuery->where('user_id','=', Auth::id());
        // }

        // // プルダウンが変更された場合の処理
        // if (request()->has('selected_affiliation2')) {
        //     $selectedAffiliation2 = request('selected_affiliation2');

        //     // プルダウンが「事業部全て」以外の場合、検索結果を絞る
        //     if ($selectedAffiliation2 != 0) {
        //         $clientsQuery->where('affiliation2_id', $selectedAffiliation2);
        //     }  // 「事業部全て」の場合は何もしない（絞り込み解除）

        //     // 上記の条件で検索結果を取得
        //     $clients = $clientsQuery->get();
            
        // } else {
        //     // 初期表示の場合、ユーザーの所属に基づいて検索結果を絞る
        //     $clientsQuery->where('affiliation2_id', $userAffiliation2)->get();
        // }
        



        $clients = $clientsQuery->paginate($perPage);
        $count = $clients->total();

        return view('clients.index',compact('clients','count','salesUsers', 'affiliation2s', 'installationTypes', 'tradeStatuses', 'clientTypes', 'selectedTradeStatuses','selectedClientTypes','selectedInstallationTypes','salesUserId', 'affiliation2Id', 'clientName', 'selectedAffiliation2', 'selectedUserId'));
    }

    public function create()
    {
        $users = User::all();
        $installationTypes = InstallationType::all(); //設置種別
        $tradeStatuses = TradeStatus::all(); //取引状態
        $clientTypes = ClientType::all(); //顧客種別
        $affiliation2s = Affiliation2::all(); //管轄事業部
        $prefectures = Prefecture::all(); //都道府県
        $distributionTypes = DistributionType::all();


        return view('clients.create',compact('affiliation2s','users','tradeStatuses','clientTypes','installationTypes','prefectures','distributionTypes'));
    }

    public function store(ClientStoreRequest $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        $inputPost = $request->head_post_code;
        // $formattedPost = Client::formatPostCode($inputPost);
        $formattedPost = PostCodeUtils::formatPostCode($inputPost);


        

        // フォームからの値を変数に格納
        $corporationNum = $request->input('corporation_num');
        $affiliation2Id = $request->input('affiliation2');
        $getaffiliation2 = Affiliation2::where('id', $affiliation2Id)->first();
        $prefix_code = $getaffiliation2->affiliation2_prefix;

        $clientNumber = Client::generateClientNumber($corporationNum, $prefix_code);


        // corporation_numからcorporation_idを取得する
        $corporation = Corporation::where('corporation_num', $corporationNum)->first();
        $corporationId = $corporation->id;

        $affiliation2 = Affiliation2::where('affiliation2_prefix', $prefix_code)->first();
        $affiliation2Id = $affiliation2->id;


        // 顧客データを保存
        $client = new Client();
        $client->client_num = $clientNumber;// 採番した顧客番号をセット

        $client->corporation_id = $corporationId;
        $client->affiliation2_id = $affiliation2Id;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $formattedPost; // 変換後の郵便番号をセット
        $client->head_prefecture = $request->head_prefecture;
        $client->head_address1 = $request->head_addre1;
        $client->head_tel = $request->head_tel;
        $client->head_fax = $request->head_fax;
        $client->students = $request->students;
        $client->distribution = $request->distribution;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->memo = $request->memo;
        $client->dealer_id = $request->dealer_id; // Vendorとリレーションしている
        $client->is_enduser = 1;
        $client->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $client->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $client->is_lease = $request->has('is_lease') ? 1 : 0;
        $client->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $client->save();

        return redirect()->route('clients.index')->with('success', '正常に登録しました');
    }



    public function show(Client $client)
    {
        //
    }

    public function edit(string $id, Request $request)
    {
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $affiliation2s = Affiliation2::all();
        $client = Client::find($id);
        $prefectures = Prefecture::all(); //都道府県
        $distributionTypes = DistributionType::all();

        $clientProducts = ClientProduct::where('client_id',$id)->orderBy('product_id','asc')->get();
        $reports = Report::where('client_id',$id)->get();
        $supports = Support::with(['client', 'user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->orderBy('received_at', 'desc')->where('client_id',$id)->paginate(25);
        // client_numとclient_nameをセッションに保存
        Session::put('selected_client_num', $client->client_num);
        Session::put('selected_client_name', $client->client_name);
        Session::put('selected_client_id', $client->id);

        $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得


        return view('clients.edit',compact('affiliation2s','users','tradeStatuses','clientTypes','installationTypes','client','reports','prefectures','supports','clientProducts','distributionTypes','activeTab',));
    }

    public function update(ClientStoreRequest $request, string $id)
    {

        $client = Client::find($id);

        $client->client_num = $request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $request->head_post_code;
        $client->head_prefecture = $request->head_prefecture_id;
        $client->head_address1 = $request->head_addre1;
        $client->head_tel = $request->head_tel;
        $client->head_fax = $request->head_fax;
        $client->students = $request->students;

        $client->distribution = $request->distribution_type_id;
        $client->affiliation2_id = $request->affiliation2;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->dealer_id = $request->dealer_id; // Vendorとリレーションしている
        $client->memo = $request->memo;
        // $client->is_enduser = $request->has('is_enduser') ? 1 : 0;
        // $client->is_supplier = $request->has('is_supplier') ? 1 : 0;
        // $client->is_dealer = $request->has('is_dealer') ? 1 : 0;
        // $client->is_lease = $request->has('is_lease') ? 1 : 0;
        // $client->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $client->save();

        // return redirect()->route('clients.edit', $id)->with('success', '正常に変更しました');
        return redirect()->back()->with('success', '正常に変更しました');
    }

    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', '正常に削除しました');
    }

    public function getClientInfo($clientId)
    {
        $client = Client::with(['clientType', 'installationType', 'affiliation2', 'user', 'tradeStatus', 'corporation', 'clientProducts.product', 'clientProducts.productVersion', 'clientProducts.product.productSeries'])
            ->where('id', $clientId)
            ->first();

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        return response()->json($client);
    }

    // //モーダル用の非同期検索ロジック
    // public function search(Request $request)
    // {
    //     $clientName = $request->input('clientName');
    //     $clientNumber = $request->input('clientNumber');
    //     $salesUser = $request->input('userId');    
    
    //     $query = Client::query();
    
    //     // clientName が空でない場合のみ条件を追加
    //     if (!empty($clientName)) {
    //         $query->where('client_name', 'LIKE', '%' . $clientName . '%');
    //     }
    
    //     // clientNumber が空でない場合のみ条件を追加
    //     if (!empty($clientNumber)) {
    //         $query->where('client_num', 'LIKE', '%' . $clientNumber . '%');
    //     }
    
    //     // salesUser が空でない場合のみ条件を追加
    //     if (!empty($salesUser)) {
    //         $query->where('user_id', $salesUser);
    //     }
    
    //     $clients = $query->with('products', 'affiliation2', 'corporation', 'user')->get();
    
    //     return response()->json($clients);
    // }

    public function search(Request $request)
    {
        // 既存の検索ロジックを活用しつつ、新しい要件に対応
        $query = Client::query();

        if (!empty($request->client_name)) {
            $query->where('client_name', 'LIKE', '%' . $request->client_name . '%');
        }

        if (!empty($request->client_number)) {
            $query->where('client_num', 'LIKE', '%' . $request->client_number . '%');
        }

        if (!empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Eager Loadingは維持
        $clients = $query->with('products', 'affiliation2', 'corporation', 'user')->get();

        // 画面IDに応じた表示項目を取得
        $displayItems = ClientSearchModalDisplayItem::where('screen_id', $request->screen_id)
            ->where('is_visible', true)
            ->orderBy('display_order')
            ->get();

        // 新しいレスポンス形式に合わせて返却
        return response()->json([
            'results' => $clients,
            'displayItems' => $displayItems
        ]);
    }

    public function updateActiveTab(Request $request)
    {
        $activeTabId = $request->input('activeTabId');
        Session::put('active_tab', $activeTabId);
        return response()->json(['message' => 'アクティブなタブが更新されました']);
    }

    public function showUploadForm()
    {
        return view('clients.upload-form');
    }





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
            $client = new Client();

            $corporationNum = $row[0];
                $corporation = Corporation::where('corporation_num', $corporationNum)->first();
                if ($corporation) {
                    $client->corporation_id = $corporation->id;
                } else {
                    // divisionが見つからない場合のエラーハンドリング
                }
            $affiliation2Code = $row[1];
                $affiliation2 = Affiliation2::where('affiliation2_code', $affiliation2Code)->first();
                if ($affiliation2) {
                    $client->affiliation2_id = $affiliation2->id;
                } else {
                    // divisionが見つからない場合のエラーハンドリング
                }

            
            $affiliation2PrefixCode = $affiliation2->affiliation2_prefix;
            $corporationNum = $corporation->corporation_num;
            $clientNumber = Client::generateClientNumber($corporationNum, $affiliation2PrefixCode);
            $client->client_num = $clientNumber;

            $client->client_name = $row[2];
            $client->client_kana_name = $row[3];

            $client->installation_type_id = $row[4];
            $client->client_type_id = $row[5];
            $client->trade_status_id = $row[6];
            $client->user_id = $row[7];
            

            $client->head_post_code = $row[8];
            $client->head_prefecture = $row[9];
            $client->head_address1 = $row[10];

            $client->head_tel = $row[11];
            $client->head_fax = $row[12];
            $client->students = $row[13];

            $client->is_enduser = $row[14];
            $client->is_supplier = $row[15];
            $client->is_dealer = $row[16];
            $client->is_lease = $row[17];
            $client->is_other_partner = $row[18];
            $client->is_closed = $row[19];
            $client->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }
}

// client_num
// memo
// distribution
// distribution_id
// head_post_code
// head_prefecture
// head_address1  