<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\Client;
use App\Models\ClientPerson;
use App\Models\Department;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;


class ClientPersonController extends Controller
{
    public function index()
    {
        $per_page = 50;   
        $clientPersons = ClientPerson::with(['client'])->orderBy('client_id','asc')->paginate($per_page);

        $count = $clientPersons->total();

        return view('client-person.index', compact('clientPersons', 'count'));
    }

    public function create()
    {
        $prefectures = Prefecture::all();
        $departments = Department::all();
        return view('client-person.create', compact('prefectures', 'departments'));
    }

    public function store(Request $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////
        $request->validate([
            // 'tel1' => 'required',
            // 'last_name' => 'required'
        ]);

        $inputPost = $request->head_post_code;
        $formattedPost = Client::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        // 顧客データを保存
        $clientPerson = new ClientPerson();

        $clientPerson->client_id = $clientId; // 取得したclient_id
        $clientPerson->last_name = $request->last_name;
        $clientPerson->first_name = $request->first_name;
        $clientPerson->last_name_kana = $request->last_name_kana;
        $clientPerson->first_name_kana = $request->first_name_kana;
        $clientPerson->division_name = $request->division_name;
        $clientPerson->position_name = $request->position_name;
        $clientPerson->tel1 = $request->tel1;
        $clientPerson->tel2 = $request->tel2;
        $clientPerson->fax1 = $request->fax1;
        $clientPerson->fax2 = $request->fax2;
        $clientPerson->int_tel = $request->int_tel;
        $clientPerson->phone = $request->phone;
        $clientPerson->mail = $request->mail;

        $clientPerson->head_post_code = $request->head_post_code; //変換後の郵便番号をセット
        $clientPerson->prefecture_id = $request->head_prefecture;
        $clientPerson->head_address1 = $request->head_addre1;
        $clientPerson->person_memo = $request->person_memo;

        $clientPerson->is_retired = $request->has('is_retired') ? 1 : 0;
        $clientPerson->is_billing_receiver = $request->has('is_billing_receiver') ? 1 : 0;
        $clientPerson->is_payment_receiver = $request->has('is_payment_receiver') ? 1 : 0;
        $clientPerson->is_support_info_receiver = $request->has('is_support_info_receiver') ? 1 : 0;
        $clientPerson->is_closing_info_receiver = $request->has('is_closing_info_receiver') ? 1 : 0;
        $clientPerson->is_exhibition_info_receiver = $request->has('is_exhibition_info_receiver') ? 1 : 0;
        $clientPerson->is_cloud_info_receiver = $request->has('is_cloud_info_receiver') ? 1 : 0;
        $clientPerson->save();

        return redirect()->back()->with('success', '正常に登録しました');
    }

    public function show(ClientPerson $clientPerson)
    {
        //
    }

    public function edit(ClientPerson $clientPerson)
    {
        $prefectures = Prefecture::all();
        $departments = Department::all();
        return view('client-person.edit', compact('prefectures', 'departments', 'clientPerson'));
    }

    public function update(Request $request, ClientPerson $clientPerson)
    {
            // FormRequestのバリデーションを通過した場合の処理を記述
    $request->validate([
        // 'tel1' => 'required',
        // 'last_name' => 'required'
    ]);

    $inputPost = $request->head_post_code;
    $formattedPost = Client::formatPostCode($inputPost);

    // フォームからの値を変数に格納
    $clientNum = $request->input('client_num');

    // client_numからclient_idを取得する
    $client = Client::where('client_num', $clientNum)->first();
    $clientId = $client->id;

    // 顧客データを更新
    // $clientPerson = ClientPerson::find($id);

    $clientPerson->client_id = $clientId; // 取得したclient_id
    $clientPerson->last_name = $request->last_name;
    $clientPerson->first_name = $request->first_name;
    $clientPerson->last_name_kana = $request->last_name_kana;
    $clientPerson->first_name_kana = $request->first_name_kana;
    $clientPerson->division_name = $request->division_name;
    $clientPerson->position_name = $request->position_name;
    $clientPerson->tel1 = $request->tel1;
    $clientPerson->tel2 = $request->tel2;
    $clientPerson->fax1 = $request->fax1;
    $clientPerson->fax2 = $request->fax2;
    $clientPerson->int_tel = $request->int_tel;
    $clientPerson->phone = $request->phone;
    $clientPerson->mail = $request->mail;

    $clientPerson->head_post_code = $request->head_post_code; // 変換後の郵便番号をセット
    $clientPerson->prefecture_id = $request->head_prefecture;
    $clientPerson->head_address1 = $request->head_addre1;
    $clientPerson->person_memo = $request->person_memo;

    $clientPerson->is_retired = $request->has('is_retired') ? 1 : 0;
    $clientPerson->is_billing_receiver = $request->has('is_billing_receiver') ? 1 : 0;
    $clientPerson->is_payment_receiver = $request->has('is_payment_receiver') ? 1 : 0;
    $clientPerson->is_support_info_receiver = $request->has('is_support_info_receiver') ? 1 : 0;
    $clientPerson->is_closing_info_receiver = $request->has('is_closing_info_receiver') ? 1 : 0;
    $clientPerson->is_exhibition_info_receiver = $request->has('is_exhibition_info_receiver') ? 1 : 0;
    $clientPerson->is_cloud_info_receiver = $request->has('is_cloud_info_receiver') ? 1 : 0;
    $clientPerson->save();

    return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ClientPerson $clientPerson)
    {
        $clientPerson->delete();
        return redirect()->route('client-person.index')->with('success', '正常に削除しました');
    }



    public function showUploadForm()
    {
        return view('client-person.upload-form');
    }


    public function upload(CsvUploadRequest $request)
    {
        session()->forget('error1');

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
        
        if ($recordCount === false) {
            // エラーが発生した場合はリダイレクトしない
            return;
        }

        if ($recordCount === false) {
            // エラーが発生した場合はリダイレクトしてエラーメッセージを表示
            return redirect()->back()->withInput()->with('error', 'エラーがあります');
        }
    
        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        // return redirect()->back()->with('success', $recordCount . '件のデータを正常にアップロードしました。');
        return redirect()->back()->with('success', '件のデータを正常にアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath, $operation)
    {
        // CSV ファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win, UTF-16, Unicode', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset)
            ->setEnclosure('"')
            ->setDelimiter(',')
            ->setIgnoreHeaderLine(true);
    
        $lexer = new Lexer($config);
    
        // トランザクション開始
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
                $existingErrors = session('error1', []);
                foreach ($errors as $lineNumber => $lineErrors) {
                    foreach ($lineErrors as $error) {
                        $existingErrors[] = "$lineNumber 行目：$error";
                    }
                }
                session(['error1' => $existingErrors]);
    
                
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
        //     $errors[] = "$lineNumber 行目：列数が5ではない行があります";
        // }

        // 顧客番号($row[0])に関して
        if (empty($row[0])) {
            // required
            $errors[] = "$lineNumber 行目：「顧客番号」は必須です";
        } elseif (mb_strlen($row[0]) !== 12) {
            // size=6
            $errors[] = "$lineNumber 行目：顧客番号は12桁でなければなりません";
        }

        // if ($operation === 'new' && Corporation::where('corporation_num', $row[0])->exists()) {
        //     $errors[] = "$lineNumber 行目：「法人番号」が重複しています";
        // }
    
        // if ($operation === 'update' && !Corporation::where('corporation_num', $row[0])->exists()) {
        //     $errors[] = "$lineNumber 行目：更新対象の「法人番号」が存在しません";
        // }


        // // 桁数チェック
        // if (mb_strlen($row[1]) > 100) {
        //     $errors[] = "$lineNumber 行目：法人名称は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[2]) > 100) {
        //     $errors[] = "$lineNumber 行目：カナ名称は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[3]) > 100) {
        //     $errors[] = "$lineNumber 行目：略称は100文字以下でなければなりません";
        // }
        // if (mb_strlen($row[4]) > 1000) {
        //     $errors[] = "$lineNumber 行目：法人備考は1000文字以下でなければなりません";
        // }

        // // 型チェック
        // if (!is_string($row[1])) {
        //     $errors[] = "$lineNumber 行目：法人名称は文字列である必要があります";
        // }
        // if (!is_string($row[2])) {
        //     $errors[] = "$lineNumber 行目：カナ名称は文字列である必要があります";
        // }
        // if (!is_string($row[3])) {
        //     $errors[] = "$lineNumber 行目：略称は文字列である必要があります";
        // }
        // if (!is_string($row[4])) {
        //     $errors[] = "$lineNumber 行目：法人備考は文字列である必要があります";
        // }
    

        return $errors;
    }
    
    private function processRow(array $row, $operation)
    {
        $clientPersonData = [
            'last_name' => $row[1],
            'first_name' => $row[2],
            'last_name_kana' => $row[3],
            'first_name_kana' => $row[4],
            'division_name' => $row[5],
            'position_name' => $row[6],
            'tel1' => $row[7],
            'fax1' => $row[8],
            'phone' => $row[9],
            'mail' => $row[10],
            'head_post_code' => $row[11],
            'prefecture_id' => $row[12], // idで登録するのか
            'head_address1' => $row[13],
            'person_memo' => $row[14],
            'is_retired' => $row[15],
            'is_billing_receiver' => $row[16],
            'is_payment_receiver' => $row[17],
            'is_support_info_receiver' => $row[18],
            'is_closing_info_receiver' => $row[19],
            'is_exhibition_info_receiver' => $row[20],
            'is_cloud_info_receiver' => $row[21],
        ];

        // client_numから対応するClientのidを取得
        $clientNum = $row[0];
        $client = Client::where('client_num', $clientNum)->first();

        if ($client) {
            // Clientが存在する場合は、そのidを関連データとして保存
            $clientPersonData['client_id'] = $client->id;
        }

        if ($operation === 'new') {
            // 新規登録の場合は$dataを保存
            ClientPerson::create($clientPersonData);
        } elseif ($existingRecord = ClientPerson::where('client_id', $client->id)->first()) {
            // 既存レコードが存在する場合は更新
            $existingRecord->update($clientPersonData);
        }
    }
}
