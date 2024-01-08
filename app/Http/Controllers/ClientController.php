<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\pagination\paginator;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 25;
        $clients = Client::with(['clientCorporation'])->sortable()->orderBy('client_num','asc')->paginate($per_page); 
        $users = User::all();
        $count = $clients->count();

        return view('client.index',compact('clients','count','users'));
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


        return view('client.create',compact('departments','users','tradeStatuses','clientTypes','installationTypes','prefectures','distributionTypes'));
    }

    public function store(ClientStoreRequest $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        $inputPost = $request->head_post_code;
        $formattedPost = Client::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $clientcorporationNum = $request->input('clientcorporation_num');
        $departmentId = $request->input('department');
        $getdepartment = Department::where('id', $departmentId)->first();
        $prefix_code = $getdepartment->prefix_code;

        $clientNumber = Client::generateClientNumber($clientcorporationNum, $prefix_code);


        // clientcorporation_numからclientcorporation_idを取得する
        $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
        $clientcorporationId = $clientcorporation->id;

        $department = Department::where('prefix_code', $prefix_code)->first();
        $departmentId = $department->id;


        // 顧客データを保存
        $client = new Client();
        $client->client_num = $clientNumber;// 採番した顧客番号をセット


        $client->client_corporation_id = $clientcorporationId;
        $client->department_id = $departmentId;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $formattedPost;//変換後の郵便番号をセット
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
        $client->distribution_id = $request->distribution_id;
        $client->is_enduser = $request->has('is_enduser') ? 1 : 0;
        $client->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $client->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $client->is_lease = $request->has('is_lease') ? 1 : 0;
        $client->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $client->save();

        return redirect()->route('client.index')->with('success', '正常に登録しました');
    }



    public function show(Client $client)
    {
        //
    }

    public function edit(string $id)
    {
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();
        $client = Client::find($id);
        $prefectures = Prefecture::all(); //都道府県
        $distributionTypes = DistributionType::all();

        $clientProducts = ClientProduct::where('client_id',$id)->orderBy('product_id','asc')->get();
        $reports = Report::where('client_id',$id)->get();
        $supports = Support::where('client_id',$id)->get();
        // client_numとclient_nameをセッションに保存
        Session::put('selected_client_num', $client->client_num);
        Session::put('selected_client_name', $client->client_name);
        Session::put('selected_client_id', $client->id);

        return view('client.edit',compact('departments','users','tradeStatuses','clientTypes','installationTypes','client','reports','prefectures','supports','clientProducts','distributionTypes'));
    }

    public function update(ClientStoreRequest $request, string $id)
    {

        $client = Client::find($id);

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
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('client.index')->with('message', '削除しました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $clientName = $request->input('clientName');
        $clientNumber = $request->input('clientNumber');
        $clientDepartment = $request->input('departmentId');

        // 検索条件に基づいて顧客データを取得
        // $clients = Client::where('client_name', 'LIKE', '%' . $clientName . '%')
        //     ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        //     ->where('department_id', 'LIKE', '%' . $clientDepartment . '%')
        //     ->get();
        $query = Client::query()
        ->where('client_name', 'LIKE', '%' . $clientName . '%')
        ->Where('client_num', 'LIKE', '%' . $clientNumber . '%')
        ->Where('department_id', 'LIKE', '%' . $clientDepartment . '%');
        $clients = $query->with('products','department','clientCorporation')->get();

        return response()->json($clients);
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
        if (!$request->hasFile('csv_input')) {
        // エラーメッセージをセットしてリダイレクト
        return redirect()->back()->with('error', 'アップロードするCSVファイルが選択されていません。');
        }

        $csvFile = $request->file('csv_input');
        
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

            $clientcorporationNum = $row[0];
                $clientCorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
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
            $clientNumber = Client::generateClientNumber($clientcorporationNum, $departmentPrefixCode);
            $client->client_num = $clientNumber;

            $client->client_name = $row[2];
            $client->client_kana_name = $row[3];

            $client->installation_type_id = $row[4];
            $client->client_type_id = $row[5];
            $client->trade_status_id = $row[6];
            $client->user_id = $row[7];
            

            $client->head_post_code = $row[8];
            $client->head_prefecture = $row[9];
            $client->head_addre1 = $row[10];

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