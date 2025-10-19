<?php
namespace App\Http\Controllers;

use App\Http\Requests\ClientContact\StoreClientContactRequest;
use App\Http\Requests\ClientContact\UpdateClientContactRequest;
use App\Http\Requests\CsvUploadRequest;
use App\Http\Resources\ClientContactResource;
use App\Models\Affiliation2;
use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientContactCheckboxOption;
use App\Models\Prefecture;
use App\Models\User;
use App\Services\PaginationService;
use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;

class ClientContactController extends Controller
{
    // チェックボックスオプションを取得するメソッド
    private function getCheckboxOptions()
    {
        return ClientContactCheckboxOption::where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }

    // チェックボックス値を保存するヘルパーメソッド
    private function saveCheckboxValues(ClientContact $clientContact, Request $request)
    {
        // 既存のチェックボックス関連をクリア
        $clientContact->checkboxOptions()->detach();
        
        // チェックボックスオプションを取得
        $checkboxOptions = ClientContactCheckboxOption::all();
        
        foreach ($checkboxOptions as $option) {
            // リクエストにチェックボックスの値が含まれているかチェック
            $value = $request->has($option->name) ? true : false;
            
            // 関連を保存
            $clientContact->checkboxOptions()->attach($option->id, ['value' => $value]);
        }
    }

    // 新しいチェックボックスオプションを追加するメソッド
    public function addCheckboxOption(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:client_contact_checkbox_options',
            'label' => 'required|string|max:255',
        ]);
        
        $lastOrder = ClientContactCheckboxOption::max('display_order') ?? 0;
        
        $option = new ClientContactCheckboxOption();
        $option->name = $validated['name'];
        $option->label = $validated['label'];
        $option->display_order = $lastOrder + 1;
        $option->save();
        
        // 既存のclient_contactレコードに対してデフォルト値を設定
        $clientContacts = ClientContact::all();
        foreach ($clientContacts as $contact) {
            $contact->checkboxOptions()->attach($option->id, ['value' => false]);
        }
        
        return redirect()->back()->with('success', 'チェックボックスが追加されました');
    }

    public function index(Request $request, PaginationService $paginationService)
    {
        $perPage = $paginationService->getPerPage($request);

        $filters = $request->only(['client_info', ]);

        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $clientContacts = ClientContact::filter($filters)
            ->with('client', 'client.department')
            ->sortable()
            ->paginate($perPage);

        // $clientContacts = ClientContact::with(['client'])->orderBy('client_id','asc')->paginate($perPage);

        // $count = $clientContacts->total();

        return view('client-contact.index', compact('clientContacts', 'filters'));
    }

    public function create()
    {
        $users = User::all();
        $prefectures = Prefecture::all();
        $affiliation2s = Affiliation2::all();
        $checkboxOptions = $this->getCheckboxOptions();
        return view('client-contact.create', compact('prefectures', 'affiliation2s', 'users', 'checkboxOptions'));
    }

    public function store(StoreClientContactRequest $request)
    {

        if ($request->client_id === null) {
            // クライアントが見つからない場合の処理
            return redirect()->back()->with('error', 'クライアントが見つかりません。');
        }

        // 顧客データを保存
        $clientContact = ClientContact::create([
            'client_id' => $request->client_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'last_name_kana' => $request->last_name_kana,
            'first_name_kana' => $request->first_name_kana,
            'division_name' => $request->division_name,
            'position_name' => $request->position_name,
            'tel1' => $request->tel1,
            'tel2' => $request->tel2,
            'fax1' => $request->fax1,
            'fax2' => $request->fax2,
            'int_tel' => $request->int_tel,
            'phone' => $request->phone,
            'mail' => $request->mail,
            'post_code' => $request->post_code, //変換後の郵便番号をセット
            'prefecture_id' => $request->prefecture_id,
            'address_1' => $request->address_1,
            'client_contact_memo' => $request->client_contact_memo,
            'is_retired' => $request->has('is_retired') ? 1 : 0,
            'is_billing_receiver' => $request->has('is_billing_receiver') ? 1 : 0,
            'is_payment_receiver' => $request->has('is_payment_receiver') ? 1 : 0,
        ]);

        // チェックボックス値の保存
        $this->saveCheckboxValues($clientContact, $request);

        return redirect()->route('client-contacts.edit', $clientContact->id)->with('success', '正常に登録しました');
    }

    public function show(ClientContact $clientContact)
    {
        //
    }

    public function edit(ClientContact $clientContact)
    {
        $users = User::all();
        $prefectures = Prefecture::all();
        $affiliation2s = Affiliation2::all();
        $checkboxOptions = $this->getCheckboxOptions();

        return view('client-contact.edit', compact('users', 'prefectures', 'affiliation2s', 'clientContact', 'checkboxOptions'));
    }

    public function update(UpdateClientContactRequest $request, ClientContact $clientContact)
    {
        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        // 顧客データを更新
        // $clientContact = ClientContact::find($id);

        $clientContact->client_id = $clientId; // 取得したclient_id
        $clientContact->last_name = $request->last_name;
        $clientContact->first_name = $request->first_name;
        $clientContact->last_name_kana = $request->last_name_kana;
        $clientContact->first_name_kana = $request->first_name_kana;
        $clientContact->division_name = $request->division_name;
        $clientContact->position_name = $request->position_name;
        $clientContact->tel1 = $request->tel1;
        $clientContact->tel2 = $request->tel2;
        $clientContact->fax1 = $request->fax1;
        $clientContact->fax2 = $request->fax2;
        $clientContact->int_tel = $request->int_tel;
        $clientContact->phone = $request->phone;
        $clientContact->mail = $request->mail;

        $clientContact->post_code = $request->post_code; // 変換後の郵便番号をセット
        $clientContact->prefecture_id = $request->prefecture_id;
        $clientContact->address_1 = $request->address_1;
        $clientContact->client_contact_memo = $request->client_contact_memo;

        $clientContact->is_retired = $request->has('is_retired') ? 1 : 0;
        $clientContact->is_billing_receiver = $request->has('is_billing_receiver') ? 1 : 0;
        $clientContact->is_payment_receiver = $request->has('is_payment_receiver') ? 1 : 0;
        $clientContact->save();

        // チェックボックス値の保存
        $this->saveCheckboxValues($clientContact, $request);

        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ClientContact $clientContact)
    {
        $clientContact->delete();
        return redirect()->route('client-contacts.index')->with('success', '正常に削除しました');
    }

    public function search(Request $request)
    {
        // 既存の検索ロジックを活用しつつ、新しい要件に対応※下記は適当
        $query = ClientContact::query();

        if (!empty($request->client_name)) {
            $query->where('client_name', 'LIKE', '%' . $request->client_name . '%');
        }

        if (!empty($request->client_number)) {
            $query->where('client_num', 'LIKE', '%' . $request->client_number . '%');
        }

        if (!empty($request->affiliation2_id)) {
            $query->where('affiliation2_id', $request->affiliation2_id);
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

    public function showUploadForm()
    {
        return view('client-contact.upload-form');
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

        if ($operation === 'new' && !Client::where('client_num', $row[0])->exists()) {
            $errors[] = "親となる「顧客番号」が存在しません";
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
        $clientContactData = [
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
            'post_code' => $row[11],
            'prefecture_id' => $row[12], // idで登録するのか
            'address_1' => $row[13],
            'client_contact_memo' => $row[14],
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
            $clientContactData['client_id'] = $client->id;
        }

        if ($operation === 'new') {
            // 新規登録の場合は$dataを保存
            ClientContact::create($clientContactData);
        } elseif ($existingRecord = ClientContact::where('client_id', $client->id)->first()) {
            // 既存レコードが存在する場合は更新
            $existingRecord->update($clientContactData);
        }
    }



    /**
     * Ajaxで顧客担当者一覧を取得
     */
    public function ajaxIndex(Client $client)
    {
        // is_activeカラムが存在しないので削除
        $contacts = $client->clientContacts()->get();

        return ClientContactResource::collection($contacts);
    }
}
