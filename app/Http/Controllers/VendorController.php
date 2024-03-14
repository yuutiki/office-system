<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;

use App\Http\Requests\VendorStoreRequest;
use App\Models\Corporation;//add
use App\Models\User;
use App\Models\Department;//add
use App\Models\ClientType;//add
use App\Models\Prefecture;//add
use App\Models\VendorType;
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
        $clientTypes = ClientType::all();
        $vendorTypes = VendorType::all();

        // ログインユーザーの所属を取得
        $userAffiliation2 = auth()->user()->department_id;
        $selectedDepartment = $userAffiliation2; // ユーザーの所属を初期値に設定

        // 検索リクエストを取得し変数に格納
        // $request->session()->put([
        //     'user_id' => $request->user_id,
        // ]);

        $selectedVendorTypes = $request->input('vendor_types', []);
        $vendorName = $request->input('vendor_name');
        $departmentId = $request->input('department_id');
        $isDealer = $request->input('is_dealer');
        $isSupplier = $request->input('is_supplier');
        $isLease = $request->input('is_lease');
        $isOtherPartner = $request->input('is_other_partner');



        // 検索クエリを組み立てる
        $vendorsQuery = Vendor::with(['corporation','user','department'])->sortable()->orderBy('vendor_num','asc');

        if (!empty($isDealer)) {
            $vendorsQuery->where('is_dealer', 1);
        }
        if (!empty($isSupplier)) {
            $vendorsQuery->where('is_supplier', 1);
        }
        if (!empty($isLease)) {
            $vendorsQuery->where('is_lease', 1);
        }
        if (!empty($isOtherPartner)) {
            $vendorsQuery->where('is_other_partner', 1);
        }

        if (!empty($selectedVendorTypes)) {
            $vendorsQuery->whereIn('vendor_type_id', $selectedVendorTypes);
        }
        if (!empty($vendorName)) {
            // Vendorモデルからclient_nameをもとにIDを取得
            $vendorIds = Vendor::where('vendor_name', 'like', '%' . $vendorName . '%')->pluck('id')->toArray();
        
            // 取得したIDを利用してサポート検索クエリに追加条件を設定
            if (!empty($vendorIds)) {
                $vendorsQuery->whereIn('id', $vendorIds);
            }
        }


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

        return view('vendors.index',compact('vendors','count','salesUsers', 'departments', 'vendorTypes','selectedVendorTypes', 'departmentId', 'vendorName', 'selectedDepartment', 'isDealer', 'isSupplier','isLease', 'isOtherPartner',));
    }

    public function create()
    {
        $users = User::all();
        $vendorTypes = VendorType::all(); //業者種別
        $departments = Department::all(); //管轄事業部
        $prefectures = Prefecture::all(); //都道府県

        return view('vendors.create',compact('departments','users','vendorTypes','prefectures',));
    }

    public function store(VendorStoreRequest $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        $inputPost = $request->head_post_code;
        $formattedPost = Vendor::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $corporationNum = $request->input('corporation_num');
        $departmentId = $request->input('department');
        $getdepartment = Department::where('id', $departmentId)->first();
        $prefix_code = $getdepartment->prefix_code;

        $vendorNumber = Vendor::generateVendorNumber($corporationNum, $prefix_code);

        // corporation_numからcorporation_idを取得する
        $corporation = Corporation::where('corporation_num', $corporationNum)->first();
        $corporationId = $corporation->id;

        $department = Department::where('prefix_code', $prefix_code)->first();
        $departmentId = $department->id;

        // 顧客データを保存
        $vendor = new Vendor();
        $vendor->vendor_num = $vendorNumber;// 採番した顧客番号をセット

        $vendor->corporation_id = $corporationId;
        $vendor->department_id = $departmentId;
        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_kana_name = $request->vendor_kana_name;
        $vendor->head_post_code = $formattedPost;//変換後の郵便番号をセット
        $vendor->head_prefecture = $request->head_prefecture;
        $vendor->head_address1 = $request->head_addre1;
        $vendor->head_tel = $request->head_tel;
        $vendor->head_fax = $request->head_fax;
        $vendor->number_of_employees = $request->number_of_employees;
        $vendor->vendor_type_id = $request->vendor_type_id;
        $vendor->memo = $request->memo;
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
        $vendorTypes = VendorType::all();
        $departments = Department::all();
        $vendor = Vendor::find($id);
        $prefectures = Prefecture::all(); //都道府県

        return view('vendors.edit',compact('departments','users','vendorTypes','vendor','prefectures',));
    }

    public function update(Request $request, string $id)
    {
        $vendor = Vendor::find($id);

        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_kana_name = $request->vendor_kana_name;
        $vendor->vendor_type_id = $request->vendor_type_id;
        $vendor->head_post_code = $request->head_post_code;
        $vendor->head_prefecture = $request->head_prefecture;
        $vendor->head_address1 = $request->head_addre1;
        $vendor->head_tel = $request->head_tel;
        $vendor->head_fax = $request->head_fax;
        $vendor->number_of_employees = $request->number_of_employees;
        $vendor->department_id = $request->department;
        $vendor->memo = $request->memo;
        $vendor->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $vendor->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $vendor->is_lease = $request->has('is_lease') ? 1 : 0;
        $vendor->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
        $vendor->save();

        return redirect()->route('vendors.edit', $id)->with('success', '正常に変更しました');
    }

    public function destroy(string $id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', '正常に削除しました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $vendorName = $request->input('vendorName');
        $vendorNumber = $request->input('vendorNumber');
        $vendorDepartment = $request->input('departmentId');
        $isDealer = $request->input('isDealer');

        // 検索条件に基づいて顧客データを取得
        // $vendors = Vendor::where('client_name', 'LIKE', '%' . $clientName . '%')
        //     ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        //     ->where('department_id', 'LIKE', '%' . $clientDepartment . '%')
        //     ->get();
        $query = Vendor::query()
        ->where('vendor_name', 'LIKE', '%' . $vendorName . '%')
        ->Where('vendor_num', 'LIKE', '%' . $vendorNumber . '%')
        ->Where('department_id', 'LIKE', '%' . $vendorDepartment . '%')
        ->where('is_dealer', '=', $isDealer);
        $vendors = $query->with('department','corporation')->get();

        return response()->json($vendors);
    }

    public function showUploadForm()
    {
        return view('vendors.upload-form');
    }


    public function upload(CsvUploadRequest $request)
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
            $vendor = new Vendor();

            $corporationNum = $row[0];
                $Corporation = Corporation::where('corporation_num', $corporationNum)->first();
                if ($Corporation) {
                    $vendor->corporation_id = $Corporation->id;
                } else {
                    // corporationが見つからない場合のエラーハンドリング
                }

            $departmentCode = $row[1];
                $department = Department::where('department_code', $departmentCode)->first();
                if ($department) {
                    $vendor->department_id = $department->id;
                } else {
                    // department_idが見つからない場合のエラーハンドリング
                }

            $corporationNum = $Corporation->corporation_num;
            $departmentPrefixCode = $department->prefix_code;
            $vendorNumber = Vendor::generateVendorNumber($corporationNum, $departmentPrefixCode);
            $vendor->vendor_num = $vendorNumber;

            $vendor->vendor_name = $row[2];
            $vendor->vendor_kana_name = $row[3];
            $vendor->vendor_type_id = $row[4];

            $vendor->head_post_code = $row[5];
            $vendor->head_prefecture = $row[6];
            $vendor->head_address1 = $row[7];
            $vendor->head_tel = $row[8];
            $vendor->head_fax = $row[9];
            $vendor->number_of_employees = $row[10];

            $vendor->is_supplier = $row[11];
            $vendor->is_dealer = $row[12];
            $vendor->is_lease = $row[13];
            $vendor->is_other_partner = $row[14];
            $vendor->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }

}
