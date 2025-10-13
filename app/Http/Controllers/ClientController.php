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
use App\Models\Contract;
use App\Models\Department;
use App\Models\DistributionType;
use App\Models\TradeStatus;//add
use App\Models\Prefecture;//add
use App\Models\Report;//add
use App\Models\Support;
use App\Services\PaginationService;
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
use Illuminate\Support\MessageBag;
use Illuminate\Support\Number;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function index(Request $request, PaginationService $paginationService)
    {
        $perPage = $paginationService->getPerPage($request);

        $departments = Department::all();
        // 親子順に並んだリストを取得
        $departments = $this->buildTree($departments);
        // $affiliation2s = Affiliation2::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $salesUsers = User::select('id', 'user_name')->get();

        $selectedUserId = $request->selected_user_id;

        // // ログインユーザーの所属を取得
        // $userAffiliation2 = auth()->user()->affiliation2_id;
        // $selectedAffiliation2 = $userAffiliation2; // ユーザーの所属を初期値に設定

        // ログインユーザーの部門ID
        // $userDepartmentId = auth()->user()->department_id ?? null;
        // $selectedDepartment = $request->input('department_id', $userDepartmentId);

        // 検索リクエストを取得し変数に格納
        $request->session()->put([
            'user_id' => $request->user_id,
        ]);
        $selectedTradeStatuses = $request->input('trade_statuses', []);
        $selectedClientTypes = $request->input('client_types', []);
        $selectedInstallationTypes = $request->input('installation_types', []);
        $clientName = $request->input('client_name');
        $salesUserId = $request->input('selected_user_id');
        $selectedDepartmentId = $request->input('department_id', auth()->user()->department_id ?? null);
        $selectedDepartmentPath = null;
        if ($selectedDepartmentId) {
            $selectedDepartmentPath = Department::find($selectedDepartmentId)?->path;
        }

        // 検索クエリを組み立てる
        $clientsQuery = Client::with(['corporation','user','tradeStatus','department'])->sortable()->orderBy('client_num','asc');

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
            $clientsQuery->where('client_name', 'like', '%' . $clientName . '%');
        }
        if (!empty($selectedDepartmentId)) {
            $department = Department::find($selectedDepartmentId);

            if ($department) {
                $ids = $department->getDescendantIds();
                $clientsQuery->whereIn('department_id', $ids);

                // パスを取得
                $selectedDepartmentPath = $department->path;
            }
        }

        $clients = $clientsQuery->paginate($perPage);

        return view('clients.index',compact(
            'clients',
            'departments','installationTypes','tradeStatuses','clientTypes',
            'selectedTradeStatuses','selectedClientTypes','selectedInstallationTypes',
            'salesUserId','clientName','selectedDepartmentId','selectedUserId','salesUsers', 'selectedDepartmentPath'
        ));
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
        $allDepartments = Department::orderBy('code')->get();

        // // ツリー形式に整形
        // $departments = $this->buildTree($allDepartments);
    
        // 方法1: Collectionのままにして、フラットな配列として渡す
    $departments = Department::select('id', 'code', 'name', 'parent_id', 'level')
                            ->orderBy('code')
                            ->get();
        

        return view('clients.create',compact('affiliation2s','users','tradeStatuses','clientTypes','installationTypes','prefectures','distributionTypes', 'departments'));
    }

    public function store(ClientStoreRequest $request)
    {
        $inputPost = $request->head_post_code;
        // $formattedPost = Client::formatPostCode($inputPost);
        // $formattedPost = PostCodeUtils::formatPostCode($inputPost);


        // フォームからの値を変数に格納
        $corporationNum = $request->input('corporation_num');
        $affiliation2Id = $request->input('affiliation2');
        $getaffiliation2 = Affiliation2::where('id', $affiliation2Id)->first();
        $prefix_code = $getaffiliation2->affiliation2_prefix;

        $clientNumber = Client::generateClientNumber($corporationNum);
        // $clientNumber = Client::generateClientNumber($corporationNum, $prefix_code);

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
        $client->post_code = $request->post_code;
        $client->prefecture_id = $request->prefecture_id;
        $client->address_1 = $request->address_1;
        $client->tel = $request->tel;
        $client->fax = $request->fax;
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
        $client->department_id = $request->department_id;
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

        $departments = Department::all();
        // 親子順に並んだリストを取得
        $departments = $this->buildTree($departments);

        $clientProducts = ClientProduct::with('product', 'productVersion')->where('client_id',$id)->orderBy('product_id','asc')->get();
        $reports = Report::with('reportType', 'reporter')->where('client_id',$id)->get();
        $supports = Support::with(['client', 'user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->orderBy('received_at', 'desc')->where('client_id',$id)->paginate(25);
        
        $contracts = Contract::with([
            'contractType',                                        // 契約種別
            'latestContractDetail.contractPartnerType',            // 最新の契約先区分
            'latestContractDetail.contractUpdateType',             // 最新の自動更新区分
            'firstContractDetail'                                  // 初回契約日用
        ])->paginate(25);

        // client_numとclient_nameをセッションに保存
        Session::put('selected_client_num', $client->client_num);
        Session::put('selected_client_name', $client->client_name);
        Session::put('selected_client_id', $client->id);

        $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得


        return view('clients.edit',compact('contracts', 'affiliation2s','users','tradeStatuses','clientTypes','installationTypes','client','reports','prefectures','supports','clientProducts','distributionTypes','activeTab', 'departments'));
    }

    private function buildTree($departments, $parentId = null, $level = 0)
    {
        $result = [];
        foreach ($departments->where('parent_id', $parentId)->sortBy('id') as $department) {
            $department->level = $level;

            // path（親からの経路文字列）を作っておくと便利
            $department->path = str_repeat('— ', $level) . $department->name;

            $result[] = $department;
            $result = array_merge($result, $this->buildTree($departments, $department->id, $level + 1));
        }
        return $result;
    }

    public function update(ClientStoreRequest $request, string $id)
    {
        $client = Client::findOrFail($id);

        // 楽観ロックチェック
        if ($client->updated_at->toISOString() !== $request->input('updated_at')) {
            $errors = new MessageBag([
                'updated_at' => '他のユーザーによって顧客基本情報が更新されています。内容をご確認の上、再度登録ボタンを押してください。',
            ]);
            return redirect()->back()
                ->withInput() // 入力値を保持
                ->withErrors($errors) // バリデーションエラーとして扱う
                ->with('error', '他のユーザーによって顧客基本情報が更新されています。');
        }

        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->post_code = $request->post_code; //
        $client->prefecture_id = $request->head_prefecture_id; //
        $client->address_1 = $request->head_addre1; //
        $client->tel = $request->head_tel;
        $client->fax = $request->head_fax;
        $client->students = $request->students;

        $client->distribution = $request->distribution_type_id; //
        $client->affiliation2_id = $request->affiliation2; //
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->dealer_id = $request->dealer_id; // Vendorとリレーションしている
        $client->memo = $request->memo;
        $client->department_id = $request->department_id;
        $client->save();

        return redirect()->back()->with('success', '正常に変更しました');
    }

    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', '正常に削除しました');
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds', []);
    
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '削除するレコードが選択されていません');
        }
    
        // 削除できない企業のIDを取得（営業報告データが存在する企業）
        $clientsWithReports = Client::whereIn('id', $selectedIds)
            ->whereHas('reports')
            ->pluck('id')
            ->toArray();
    
        // 削除可能な企業のIDを取得（営業報告データがない企業）
        $clientsToDelete = array_diff($selectedIds, $clientsWithReports);
    
        if (!empty($clientsToDelete)) {
            Client::whereIn('id', $clientsToDelete)->delete();
        }
    
        // メッセージを設定
        if (!empty($clientsWithReports)) {
            return redirect()->back()->with('error', '一部の顧客は営業報告データが存在するため、削除できませんでした');
        }
    
        return redirect()->back()->with('success', '選択された顧客を削除しました');
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
        $clients = $query->with('products', 'affiliation2', 'corporation', 'user', 'department')->get();

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
            

            $client->post_code = $row[8];
            $client->prefecture_id = $row[9];
            $client->address_1 = $row[10];

            $client->tel = $row[11];
            $client->fax = $row[12];
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