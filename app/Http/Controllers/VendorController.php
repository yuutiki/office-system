<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

use App\Http\Requests\ClientStoreRequest;
use App\Models\ClientCorporation;//add
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\User;
use App\Models\Department;//add
use App\Models\InstallationType;//add
use App\Models\ClientType;//add
use App\Models\DistributionType;
use App\Models\TradeStatus;//add
use App\Models\Prefecture;//add
use App\Models\Report;//add
use App\Models\Support;
use Illuminate\pagination\paginator;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 50;

        // 検索条件用
        $salesUsers = User::all();
        $departments = Department::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();

        // ログインユーザーの所属を取得
        $userAffiliation2 = auth()->user()->department_id;
        $selectedDepartment = $userAffiliation2; // ユーザーの所属を初期値に設定

        // 検索リクエストを取得し変数に格納
        $request->session()->put([
            'user_id' => $request->user_id,
        ]);
        $selectedTradeStatuses = $request->input('trade_statuses', []);
        $selectedClientTypes = $request->input('client_types', []);
        $selectedInstallationTypes = $request->input('installation_types', []);
        $clientName = $request->input('client_name');
        $salesUserId = $request->input('user_id');
        $departmentId = $request->input('department_id');

        // 検索クエリを組み立てる
        $vendorsQuery = Vendor::with(['clientCorporation','user','tradeStatus','department'])->sortable()->orderBy('vendor_num','asc');

        if (!empty($selectedTradeStatuses)) {// 取引状態
            $vendorsQuery->whereIn('trade_status_id', $selectedTradeStatuses);
        }
        if (!empty($selectedVendorTypes)) {// 顧客種別
            $vendorsQuery->whereIn('client_type_id', $selectedVendorTypes);
        }
        if (!empty($selectedInstallationTypes)) {// 設置種別
            $vendorsQuery->whereIn('installation_type_id', $selectedInstallationTypes);
        }
        if (!empty($clientName)) {
            // Vendorモデルからclient_nameをもとにIDを取得
            $clientIds = Vendor::where('vendor_name', 'like', '%' . $clientName . '%')->pluck('id')->toArray();
        
            // 取得したIDを利用してサポート検索クエリに追加条件を設定
            if (!empty($clientIds)) {
                $vendorsQuery->whereIn('id', $clientIds);
            }
        }


        if (!empty($salesUserId)) {
            $vendorsQuery->where('user_id','=', $salesUserId);
        }

        // // 初期表示で絞る
        // if (empty($salesUserId)) {
        //     $vendorsQuery->where('user_id','=', Auth::id());
        // }

        // プルダウンが変更された場合の処理
        if (request()->has('selected_department')) {
            $selectedDepartment = request('selected_department');

            // プルダウンが「事業部全て」以外の場合、検索結果を絞る
            if ($selectedDepartment != 0) {
                $vendorsQuery->where('department_id', $selectedDepartment);
            }  // 「事業部全て」の場合は何もしない（絞り込み解除）

            // 上記の条件で検索結果を取得
            $vendors = $vendorsQuery->get();
            
        } else {
            // 初期表示の場合、ユーザーの所属に基づいて検索結果を絞る
            $vendorsQuery->where('department_id', $userAffiliation2)->get();
        }



        $vendors = $vendorsQuery->paginate($per_page);
        $count = $vendors->total();

        return view('vendors.index',compact('vendors','count','salesUsers', 'departments', 'installationTypes', 'tradeStatuses', 'clientTypes', 'selectedTradeStatuses','selectedClientTypes','selectedInstallationTypes','salesUserId', 'departmentId', 'clientName', 'selectedDepartment'));
    }

    public function create()
    {
        $users = User::all();
        $installationTypes = InstallationType::all(); //設置種別
        $tradeStatuses = TradeStatus::all(); //取引状態
        $clientTypes = ClientType::all(); //顧客種別
        $departments = Department::all(); //管轄事業部
        $prefectures = Prefecture::all(); //都道府県
        $distributionTypes = DistributionType::all();


        return view('vendors.create',compact('departments','users','tradeStatuses','clientTypes','installationTypes','prefectures','distributionTypes'));
    }

    public function store(Request $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        $inputPost = $request->head_post_code;
        $formattedPost = Vendor::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $clientcorporationNum = $request->input('clientcorporation_num');
        $departmentId = $request->input('department');
        $getdepartment = Department::where('id', $departmentId)->first();
        $prefix_code = $getdepartment->prefix_code;

        $vendorNumber = Vendor::generateVendorNumber($clientcorporationNum, $prefix_code);


        // clientcorporation_numからclientcorporation_idを取得する
        $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
        $clientcorporationId = $clientcorporation->id;

        $department = Department::where('prefix_code', $prefix_code)->first();
        $departmentId = $department->id;


        // 顧客データを保存
        $vendor = new Vendor();
        $vendor->vendor_num = $vendorNumber;// 採番した顧客番号をセット


        $vendor->client_corporation_id = $clientcorporationId;
        $vendor->department_id = $departmentId;
        $vendor->vendor_name = $request->client_name;
        $vendor->vendor_kana_name = $request->client_kana_name;
        $vendor->head_post_code = $formattedPost;//変換後の郵便番号をセット
        $vendor->head_prefecture = $request->head_prefecture;
        $vendor->head_address1 = $request->head_addre1;
        $vendor->head_tel = $request->head_tel;
        $vendor->head_fax = $request->head_fax;
        $vendor->number_of_employees = $request->number_of_employees;
        // $vendor->distribution = $request->distribution;
        $vendor->vendor_type_id = $request->client_type_id;
        // $vendor->installation_type_id = $request->installation_type_id;
        $vendor->trade_status_id = $request->trade_status_id;
        // $vendor->user_id = $request->user_id;
        $vendor->memo = $request->memo;
        // $vendor->distribution_id = $request->distribution_id;
        // $vendor->is_enduser = $request->has('is_enduser') ? 1 : 0;
        $vendor->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $vendor->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $vendor->is_lease = $request->has('is_lease') ? 1 : 0;
        $vendor->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $vendor->save();

        return redirect()->route('vendors.index')->with('success', '正常に登録しました');
    }



    public function show(Vendor $client)
    {
        //
    }

    public function edit(string $id)
    {
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = VendorType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();
        $client = Vendor::find($id);
        $prefectures = Prefecture::all(); //都道府県
        $distributionTypes = DistributionType::all();

        $clientProducts = VendorProduct::where('client_id',$id)->orderBy('product_id','asc')->get();
        $reports = Report::where('client_id',$id)->get();
        $supports = Support::with(['client', 'user', 'productSeries', 'productVersion', 'productCategory', 'supportType', 'supportTime'])->where('client_id',$id)->paginate(25);
        // client_numとclient_nameをセッションに保存
        Session::put('selected_client_num', $client->client_num);
        Session::put('selected_client_name', $client->client_name);
        Session::put('selected_client_id', $client->id);

        return view('client.edit',compact('departments','users','tradeStatuses','clientTypes','installationTypes','client','reports','prefectures','supports','clientProducts','distributionTypes'));
    }

    public function update(VendorStoreRequest $request, string $id)
    {

        $client = Vendor::find($id);

        $client->client_num = $request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $request->head_post_code;
        $client->head_prefecture = $request->head_prefecture;
        $client->head_address1 = $request->head_addre1;
        $client->head_tel = $request->head_tel;
        $client->head_fax = $request->head_fax;
        $client->students = $request->students;
        $client->distribution = $request->distribution_type_id;
        $client->department_id = $request->department;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->memo = $request->memo;
        $client->is_enduser = $request->has('is_enduser') ? 1 : 0;
        $client->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $client->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $client->is_lease = $request->has('is_lease') ? 1 : 0;
        $client->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $client->save();

        return redirect()->route('client.edit', $id)->with('success', '正常に変更しました');
    }

    public function destroy(string $id)
    {
        $client = Vendor::find($id);
        $client->delete();

        return redirect()->route('vendors.index')->with('success', '正常に削除しました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $clientName = $request->input('clientName');
        $clientNumber = $request->input('clientNumber');
        $clientDepartment = $request->input('departmentId');
        $isDealer = $request->input('isDealer');

        // 検索条件に基づいて顧客データを取得
        // $vendors = Vendor::where('client_name', 'LIKE', '%' . $clientName . '%')
        //     ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        //     ->where('department_id', 'LIKE', '%' . $clientDepartment . '%')
        //     ->get();
        $query = Vendor::query()
        ->where('client_name', 'LIKE', '%' . $clientName . '%')
        ->Where('client_num', 'LIKE', '%' . $clientNumber . '%')
        ->Where('department_id', 'LIKE', '%' . $clientDepartment . '%')
        ->where('is_dealer', '=', $isDealer);
        $vendors = $query->with('products','department','clientCorporation')->get();

        return response()->json($vendors);
    }

    public function updateActiveTab(Request $request)
    {
        $activeTabId = $request->input('activeTabId');
        Session::put('active_tab', $activeTabId);
        return response()->json(['message' => 'アクティブなタブが更新されました']);
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
            $client = new Vendor();

            $clientcorporationNum = $row[0];
                $clientCorporation = VendorCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
                if ($clientCorporation) {
                    $client->client_corporation_id = $clientCorporation->id;
                } else {
                    // divisionが見つからない場合のエラーハンドリング
                }
            $departmentCode = $row[1];
                $department = Department::where('department_code', $departmentCode)->first();
                if ($department) {
                    $client->department_id = $department->id;
                } else {
                    // divisionが見つからない場合のエラーハンドリング
                }

            
            $departmentPrefixCode = $department->prefix_code;
            $clientcorporationNum = $clientCorporation->clientcorporation_num;
            $clientNumber = Vendor::generateVendorNumber($clientcorporationNum, $departmentPrefixCode);
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
