<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;

use App\Http\Requests\VendorStoreRequest;
use App\Models\Corporation;//add
use App\Models\User;
use App\Models\Affiliation2;//add
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
use Illuminate\Support\Facades\Http;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');

        // 検索条件用
        $salesUsers = User::all();
        $affiliation2s = Affiliation2::all();
        $clientTypes = ClientType::all();
        $vendorTypes = VendorType::all();

        // ログインユーザーの所属を取得
        $userAffiliation2 = auth()->user()->affiliation2_id;
        $selectedAffiliation2 = $userAffiliation2; // ユーザーの所属を初期値に設定

        // 検索リクエストを取得し変数に格納
        // $request->session()->put([
        //     'user_id' => $request->user_id,
        // ]);

        $selectedVendorTypes = $request->input('vendor_types', []);
        $vendorName = $request->input('vendor_name');
        $affiliation2Id = $request->input('affiliation2_id');
        $isDealer = $request->input('is_dealer');
        $isSupplier = $request->input('is_supplier');
        $isLease = $request->input('is_lease');
        $isOtherPartner = $request->input('is_other_partner');



        // 検索クエリを組み立てる
        $vendorsQuery = Vendor::with(['corporation','user','affiliation2'])->sortable()->orderBy('vendor_num','asc');

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
        if (request()->has('selected_affiliation2')) {
            $selectedAffiliation2 = request('selected_affiliation2');

            // プルダウンが「事業部全て」以外の場合、検索結果を絞る
            if ($selectedAffiliation2 != 0) {
                $vendorsQuery->where('affiliation2_id', $selectedAffiliation2);
            }  // 「事業部全て」の場合は何もしない（絞り込み解除）

            // 上記の条件で検索結果を取得
            $vendors = $vendorsQuery->get();
            
        } else {
            // 初期表示の場合、ユーザーの所属に基づいて検索結果を絞る
            $vendorsQuery->where('affiliation2_id', $userAffiliation2)->get();
        }

        $vendors = $vendorsQuery->paginate($perPage);
        $count = $vendors->total();

        return view('vendors.index',compact('vendors','count','salesUsers', 'affiliation2s', 'vendorTypes','selectedVendorTypes', 'affiliation2Id', 'vendorName', 'selectedAffiliation2', 'isDealer', 'isSupplier','isLease', 'isOtherPartner',));
    }

    public function create()
    {
        $users = User::all();
        $vendorTypes = VendorType::all(); //業者種別
        $affiliation2s = Affiliation2::all(); //管轄事業部
        $prefectures = Prefecture::all(); //都道府県

        return view('vendors.create',compact('affiliation2s','users','vendorTypes','prefectures',));
    }

    public function store(VendorStoreRequest $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        $inputPost = $request->vendor_post_code;
        $formattedPost = Vendor::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $corporationNum = $request->input('corporation_num');
        $affiliation2Id = $request->input('affiliation2');
        $getaffiliation2 = Affiliation2::where('id', $affiliation2Id)->first();
        $prefix_code = $getaffiliation2->affiliation2_prefix;

        $vendorNumber = Vendor::generateVendorNumber($corporationNum, $prefix_code);

        // corporation_numからcorporation_idを取得する
        $corporation = Corporation::where('corporation_num', $corporationNum)->first();
        $corporationId = $corporation->id;

        $affiliation2 = Affiliation2::where('affiliation2_prefix', $prefix_code)->first();
        $affiliation2Id = $affiliation2->id;

        // 顧客データを保存
        $vendor = new Vendor();

        $vendor->vendor_num = $vendorNumber;// 採番した顧客番号をセット
        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_kana_name = $request->vendor_kana_name;
        $vendor->corporation_id = $corporationId;
        $vendor->affiliation2_id = $affiliation2Id;
        $vendor->vendor_type_id = $request->vendor_type_id;

        $vendor->vendor_post_code = $formattedPost;//変換後の郵便番号をセット
        $vendor->vendor_prefecture_id = $request->vendor_prefecture_id;
        $vendor->vendor_address1 = $request->vendor_address1;
        $vendor->vendor_tel = $request->vendor_tel;
        $vendor->vendor_fax = $request->vendor_fax;
        $vendor->number_of_employees = $request->number_of_employees;
        $vendor->vendor_memo = $request->vendor_memo;
        $vendor->vendor_url = $request->vendor_url;

        $vendor->bank_code = $request->bank_code;
        $vendor->branch_code = $request->branch_code;

        $vendor->account_type = $request->account_type;
        $vendor->account_number = $request->account_number;
        $vendor->account_name = $request->account_name;


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
        $affiliation2s = Affiliation2::all();
        $vendor = Vendor::find($id);
        $prefectures = Prefecture::all(); //都道府県

        return view('vendors.edit',compact('affiliation2s','users','vendorTypes','vendor','prefectures',));
    }

    public function update(Request $request, string $id)
    {
        $vendor = Vendor::findOrFail($id);

        $this->updateBasicInfo($vendor, $request);
        $this->updateBankInfo($vendor, $request);
        $this->updateAccountInfo($vendor, $request);

        $vendor->save();

        return redirect()->route('vendors.edit', $id)->with('success', '正常に変更しました');
    }

    private function updateBasicInfo(Vendor $vendor, Request $request)
    {
        $formattedPost = Vendor::formatPostCode($request->vendor_post_code);

        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_kana_name = $request->vendor_kana_name;
        $vendor->vendor_memo = $request->vendor_memo;
        $vendor->vendor_url = $request->vendor_url;
        $vendor->number_of_employees = $request->number_of_employees;
        $vendor->affiliation2_id = $request->affiliation2;
        $vendor->vendor_type_id = $request->vendor_type_id;
        $vendor->vendor_post_code = $formattedPost;
        $vendor->vendor_prefecture_id = $request->vendor_prefecture_id;
        $vendor->vendor_address1 = $request->vendor_address1;
        $vendor->vendor_tel = $request->vendor_tel;
        $vendor->vendor_fax = $request->vendor_fax;
        $vendor->is_supplier = $request->has('is_supplier') ? 1 : 0;
        $vendor->is_dealer = $request->has('is_dealer') ? 1 : 0;
        $vendor->is_lease = $request->has('is_lease') ? 1 : 0;
        $vendor->is_other_partner = $request->has('is_other_partner') ? 1 : 0;
    }

    private function updateBankInfo(Vendor $vendor, Request $request)
    {
        $bankCode = $request->bank_code;
        $branchCode = $request->branch_code_1 . $request->branch_code_2 . $request->branch_code_3;

        if (!$bankCode || !$branchCode) {
            return; // 銀行コードまたは支店コードが入力されていない場合は更新しない
        }

        $bankInfo = $this->verifyBankInfo($bankCode);
        if (!$bankInfo) {
            return redirect()->back()->with('error', '指定された銀行が見つかりません。');
            // throw new \Exception('指定された銀行が見つかりません。');
        }

        $branchInfo = $this->verifyBranchInfo($bankCode, $branchCode);
        if (!$branchInfo) {
            return redirect()->back()->with('error', '指定された支店が見つかりません。');
            // throw new \Exception('指定された支店が見つかりません。');
        }

        $vendor->bank_code = $bankCode;
        $vendor->bank_name = $bankInfo['normalize']['name'];
        $vendor->branch_code = $branchCode;
        $vendor->branch_name = $branchInfo['name'];
    }

    private function updateAccountInfo(Vendor $vendor, Request $request)
    {
        $accountNumber = $request->account_number_1 . $request->account_number_2 . $request->account_number_3 .
                         $request->account_number_4 . $request->account_number_5 . $request->account_number_6 .
                         $request->account_number_7;

        $accountNameSei = $this->convertAccountName($request->account_name_sei);
        $accountNameMei = $this->convertAccountName($request->account_name_mei);
        $accountName = trim($accountNameSei . ' ' . $accountNameMei);

        $isAccountTypeSelected = $request->filled('account_type') || $request->account_type === '0';
        $isAccountNumberComplete = strlen($accountNumber) === 7;
        $isAccountNameProvided = !empty($accountNameSei) || !empty($accountNameMei);

        if (!$isAccountTypeSelected || !$isAccountNumberComplete || !$isAccountNameProvided) {
            return; // 必要な情報が不足している場合は更新しない
        }

        $vendor->account_type = $request->account_type;
        $vendor->account_number = $accountNumber;
        $vendor->account_name = $accountName;
    }

    private function convertAccountName($name)
    {
        // 全角を半角に変換（カナも含む）
        $name = mb_convert_kana($name, 'rnkas', 'UTF-8');

        // 半角カナの小文字を大文字に変換
        $name = $this->convertHalfwidthKanaToUppercase($name);

        // 英字の小文字を大文字に変換
        $name = strtoupper($name);

        // 許可された文字のみをフィルタリング
        $allowedChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
                        'ｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜｦﾝ' .
                        'ﾞﾟ\\,.()-/ ';
        $name = preg_replace('/[^' . preg_quote($allowedChars, '/') . ']/u', '', $name);

        // 中黒点をピリオドに置換
        $name = str_replace('・', '.', $name);

        // カナ長音文字をマイナスに置換
        $name = str_replace('ー', '-', $name);

        return $name;
    }

    private function convertHalfwidthKanaToUppercase($string)
    {
        $kanaMap = [
            'ｧ' => 'ｱ', 'ｨ' => 'ｲ', 'ｩ' => 'ｳ', 'ｪ' => 'ｴ', 'ｫ' => 'ｵ',
            'ｯ' => 'ﾂ', 'ｬ' => 'ﾔ', 'ｭ' => 'ﾕ', 'ｮ' => 'ﾖ',
            'ｳﾞ' => 'ｳﾞ', 'ｶﾞ' => 'ｶﾞ', 'ｷﾞ' => 'ｷﾞ', 'ｸﾞ' => 'ｸﾞ', 'ｹﾞ' => 'ｹﾞ', 'ｺﾞ' => 'ｺﾞ',
            'ｻﾞ' => 'ｻﾞ', 'ｼﾞ' => 'ｼﾞ', 'ｽﾞ' => 'ｽﾞ', 'ｾﾞ' => 'ｾﾞ', 'ｿﾞ' => 'ｿﾞ',
            'ﾀﾞ' => 'ﾀﾞ', 'ﾁﾞ' => 'ﾁﾞ', 'ﾂﾞ' => 'ﾂﾞ', 'ﾃﾞ' => 'ﾃﾞ', 'ﾄﾞ' => 'ﾄﾞ',
            'ﾊﾞ' => 'ﾊﾞ', 'ﾋﾞ' => 'ﾋﾞ', 'ﾌﾞ' => 'ﾌﾞ', 'ﾍﾞ' => 'ﾍﾞ', 'ﾎﾞ' => 'ﾎﾞ',
            'ﾊﾟ' => 'ﾊﾟ', 'ﾋﾟ' => 'ﾋﾟ', 'ﾌﾟ' => 'ﾌﾟ', 'ﾍﾟ' => 'ﾍﾟ', 'ﾎﾟ' => 'ﾎﾟ'
        ];

        return strtr($string, $kanaMap);
    }


    private function verifyBankInfo($bankCode)
    {
        $response = Http::get("https://bank.teraren.com/banks/{$bankCode}.json");
        return $response->successful() ? $response->json() : null;
    }

    private function verifyBranchInfo($bankCode, $branchCode)
    {
        $response = Http::get("https://bank.teraren.com/banks/{$bankCode}/branches/{$branchCode}.json");
        return $response->successful() ? $response->json() : null;
    }










    public function destroy(string $ulid)
    {
        $vendor = Vendor::find($ulid);
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', '正常に削除しました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $vendorName = $request->input('vendorName');
        $vendorNumber = $request->input('vendorNumber');
        $vendorAffiliation2 = $request->input('affiliation2Id');
        $isDealer = $request->input('isDealer');

        // 検索条件に基づいて顧客データを取得
        // $vendors = Vendor::where('client_name', 'LIKE', '%' . $clientName . '%')
        //     ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        //     ->where('affiliation2_id', 'LIKE', '%' . $clientAffiliation2 . '%')
        //     ->get();
        $query = Vendor::query()
        ->where('vendor_name', 'LIKE', '%' . $vendorName . '%')
        ->Where('vendor_num', 'LIKE', '%' . $vendorNumber . '%')
        ->Where('affiliation2_id', 'LIKE', '%' . $vendorAffiliation2 . '%')
        ->where('is_dealer', '=', $isDealer);
        $vendors = $query->with('affiliation2','corporation')->get();

        return response()->json($vendors);
    }

    public function showUploadForm()
    {
        return view('vendors.upload-form');
    }

    public function upload(CsvUploadRequest $request)
    {
        session()->forget('validatedErrors');

        $csvFile = $request->file('csv_upload');
        
        // CSVファイルの一時保存先パス
        $csvPath = $csvFile->getRealPath();
        
        // ラジオボタンの選択状態を確認
        $radioOption = $request->input('processing_type');

        // 分岐処理
        if ($radioOption === 'new') {
            // 新規登録の処理
            $recordCount = $this->parseCSVAndSaveToDatabase($csvPath, 'new');
        } elseif ($radioOption === 'update') {
            // 既存更新の処理
            $recordCount = $this->parseCSVAndSaveToDatabase($csvPath, 'update');
        } else {
            // バリデーション：更新種別が選択されていない場合（ほぼ起こり得ない）
            return redirect()->back()->with('error', '処理種別が選択されていません。');
        }

        if (!is_numeric($recordCount)) {
            // エラーが発生し数値以外が返ってきた（例外がスローされた）場合はリダイレクトしてエラーメッセージを表示
            return redirect()->back()->withInput()->with('error', 'エラーがあります');
        }

        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', $recordCount . '件のデータを正常にアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath, $operation)
    {
        // CSVファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win, UTF-16, Unicode', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset)
            ->setEnclosure('"')
            ->setDelimiter(',')
            ->setIgnoreHeaderLine(true); // ヘッダを無視する設定

        $lexer = new Lexer($config);

        DB::beginTransaction();

        try {
            $recordCount = 0;
            $lineNumber = 1;
            $errors = [];

            $interpreter = new Interpreter();
            $interpreter->addObserver(function (array $row) use ($operation, &$recordCount, &$lineNumber, &$errors) {
                $lineNumber++;
    
                $rowErrors = $this->validateRow($row, $operation, $lineNumber);
                if (!empty($rowErrors)) {
                    // 行ごとのエラーを$errorsに追加
                    $errors[$lineNumber] = $rowErrors;
                } else {
                    // エラーがなければ処理を継続し、データを登録する
                    $this->processRow($row, $operation);
                    $recordCount++;
                }
            });

            $lexer->parse($csvPath, $interpreter);
    
            // エラーがある場合はトランザクションをロールバックしてエラーメッセージをセッションに保存
            if (!empty($errors)) {
                DB::rollBack();
                $existingErrors = session('validatedErrors', []);
                foreach ($errors as $lineNumber => $lineErrors) {
                    foreach ($lineErrors as $error) {
                        $existingErrors[] = "$lineNumber 行目：$error";
                    }
                }
                session(['validatedErrors' => $existingErrors]);
    
                
                return redirect()->back()->withInput()->with('error', 'エラーがあります');
            }

            // トランザクションコミット
            DB::commit();
            return $recordCount;

        } catch (\Exception $e) {
            // トランザクションロールバック
            DB::rollBack();
            throw $e;
        }

    }

    private function validateRow(array $row, $operation, $lineNumber)
    {
        $errors = [];
    
        // if (count($row) !== 5) {
        //     $errors[] = "列数が5ではない行があります";
        // }

        // 法人番号($row[0])に関して
        if (empty($row[0])) {
            // required
            $errors[] = "「法人番号」は必須です";
        } elseif (mb_strlen($row[0]) !== 6) {
            // size=6
            $errors[] = "「法人番号」は6桁でなければなりません";
        } elseif (!Corporation::where('corporation_num', $row[0])->exists()) {
            // corporation_numが存在しない場合のエラーハンドリング
            $errors[] = "「法人番号」が見つかりません";
        }

        // if ($operation === 'new' && Vendor::where('vendor_num', $row[0])->exists()) {
        //     $errors[] = " 「業者番号」が重複しています";
        // }
    
        // if ($operation === 'update' && !Vendor::where('vendor_num', $row[0])->exists()) {
        //     $errors[] = "更新対象の「業者番号」が存在しません";
        // }


        // // 桁数チェック
        // if (mb_strlen($row[1]) > 100) {
        //     $errors[] = " 「法人名称」は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[2]) > 100) {
        //     $errors[] = " 「カナ名称」は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[3]) > 100) {
        //     $errors[] = " 「略称」は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[4]) > 1000) {
        //     $errors[] = " 「法人備考」は1000文字以下でなければなりません";
        // }

        // // 型チェック
        // if (!is_string($row[1])) {
        //     $errors[] = " 「法人名称」は文字列である必要があります";
        // }
        // if (!is_string($row[2])) {
        //     $errors[] = " 「カナ名称」は文字列である必要があります";
        // }
        // if (!is_string($row[3])) {
        //     $errors[] = " 「略称」は文字列である必要があります";
        // }
        // if (!is_string($row[4])) {
        //     $errors[] = " 「法人備考」は文字列である必要があります";
        // }
    
        return $errors;
    }

    private function processRow(array $row, $operation)
    {
        $corporationNum = $row[0];
            $Corporation = Corporation::where('corporation_num', $corporationNum)->first();
            if ($Corporation) {
                $corporationId = $Corporation->id;
            } else {
                // corporationが見つからない場合のエラーハンドリング
                $corporationId = null;
            }

        $affiliation2Code = $row[1];
        // dd($affiliation2Code);

            $affiliation2 = Affiliation2::where('affiliation2_code', $affiliation2Code)->first();
            if ($affiliation2) {
                $affiliation2Id = $affiliation2->id;
            } else {
                // affiliation2_idが見つからない場合のエラーハンドリング
                $affiliation2Id = null;
            }

        // $corporationNum = $Corporation->corporation_num;
        $affiliation2PrefixCode = $affiliation2->prefix_code;
        $vendorNumber = Vendor::generateVendorNumber($corporationNum, $affiliation2PrefixCode);

        $data = [
            'vendor_num' => $vendorNumber,
            'corporation_id' => $corporationId,
            'affiliation2_id' => $affiliation2Id,
            'vendor_name' => $row[2],
            'vendor_kana_name' => $row[3],
            'vendor_type_id' => $row[4],
            'head_post_code' => $row[5],
            'head_prefecture' => $row[6],
            'head_address1' => $row[7],
            'head_tel' => $row[8],
            'head_fax' => $row[9],
            'number_of_employees' => $row[10],
            'is_supplier' => $row[11],
            'is_dealer' => $row[12],
            'is_lease' => $row[13],
            'is_other_partner' => $row[14],
        ];

        if ($operation === 'new') {
            // 新規登録の場合は$dataを保存
            Vendor::create($data);
        } elseif ($existingRecord = Vendor::where('vendor_num', $row[0])->first()) {
            // 既存レコードが存在する場合は更新
            $existingRecord->update($data);
        }
    }
}
