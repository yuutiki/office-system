<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorporationStoreRequest;
use App\Http\Requests\CorporationUpdateRequest;
use App\Http\Requests\CorporationUploadRequest;
use App\Models\Corporation;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Goodby\CSV\Import\Standard\InterpreterConfig;
use Illuminate\Support\Facades\Response;
use App\Jobs\ExportCorporationsCsv;
use App\Models\CorporationCredit;
use App\Models\Prefecture;
use Illuminate\Support\Facades\Session;

class CorporationController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        // １ページごとの表示件数
        $perPage = config('constants.perPage');

        // 検索条件を取得してセッションに保存
        $searchParams = $request->session()->put('search_params', $request->all());

        // リクエストから並び替えの条件を取得しSessionに保存
        $request->session()->put([
            'sort_by' => $request->input('sort', 'id'),
            'sort_direction' => $request->input('direction', 'asc'),
        ]);

        // 検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['corporation_num', 'corporation_name', 'invoice_num']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $CorporationNum = $filters['corporation_num'] ?? null;
        $CorporationName = $filters['corporation_name'] ?? null;
        $invoiceNum = $filters['invoice_num'] ?? null;

        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $corporations = Corporation::filter($filters)
            ->with('prefecture')
            ->withCount('clients')
            ->addSelect(['latest_credit_limit' => CorporationCredit::select('credit_limit')
                ->whereColumn('corporation_id', 'corporations.id')
                ->latest()
                ->limit(1)
            ])
            ->sortable()
            ->paginate($perPage);
            
        // 検索結果の件数を取得
        $count = $corporations->total();

        return view('corporations.index', compact('searchParams', 'corporations', 'count' ,'filters', 'CorporationNum', 'CorporationName','invoiceNum',));
    }

    public function create()
    {
        $prefectures = Prefecture::all();
        return view('corporations.create',compact('prefectures',));
    }

    public function store(CorporationStoreRequest $request)
    {
        $result = Corporation::storeWithTransaction($request->except('corporation_num'));

        if ($result) {
            // 作成されたcorporationのIDを取得
            $corporationId = $result->id;
            // 編集画面へのURLを生成
            $editUrl = route('corporations.edit', ['corporation' => $corporationId]);
    
            // 生成されたURLにリダイレクト
            return redirect($editUrl)->with('success', '正常に登録しました');
        } else {
            return back()->with('error', '登録に失敗しました。');
        }
    }

    public function show(Corporation $Corporation)
    {
        //
    }

    public function edit(string $id, Request $request)
    {
        $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得
        $prefectures = Prefecture::all();

        $corporation = Corporation::findOrFail($id);
        $credits = CorporationCredit::where('corporation_id',$id)->orderBy('created_at','desc')->get();

        // 最新の与信情報を取得
        $latestCredit = $corporation->credits()->orderBy('created_at', 'desc')->first();

        return view('corporations.edit',compact('corporation','prefectures','activeTab','credits', 'latestCredit',));
    }

    public function update(CorporationUpdateRequest $request, string $id)
    {
        try {
            // モデルを見つけて、存在するか確認
            $corporation = Corporation::findOrFail($id);

            // データを更新
            $corporation->fill($request->all())->save();
            // return redirect()->route('corporations.edit', $id)->with('success', '正常に更新されました');

            // // 新規登録用の与信情報の追加
            // if (!empty($request->input('credit_limit'))) {
            //     $corporation->credits()->create([
            //         'credit_limit' => $request->input('credit_limit'),
            //         'credit_rate' => $request->input('credit_rate'),
            //         'credit_rater' => $request->input('credit_rater'),
            //         'credit_reason' => $request->input('credit_reason'),
            //         // 他の与信情報のカラムを追加
            //     ]);
            // }
            return redirect()->back()->with('success', '正常に更新されました');
            
        } catch (ModelNotFoundException $e) {
            // モデルが見つからない場合のエラーメッセージ
            return redirect()->back()->with('error', '指定されたデータが見つかりませんでした');
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            // 検索条件を取得
            $searchParams = $request->session()->get('search_params', []);
        
            // 子データが存在するか確認
            $Corporation = Corporation::with('clients')->findOrFail($id);

            // 子データが存在する場合は削除を中止
            if ($Corporation->clients()->exists()) {
                return redirect()->back()->with('error', '顧客データが存在するため、削除できません');
            }

            // 子データが存在しない場合は削除を実行
            $Corporation->delete();
            return redirect()->route('corporations.index', $searchParams)->with('success', '正常に削除されました');            

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', '対象のデータが見つかりませんでした');
        }
    }

    //モーダル用の非同期検索メソッド
    public function search(Request $request)
    {
        $corporationName = $request->input('corporationName');
        $corporationNumber = $request->input('corporationNumber');

        // 検索条件に基づいて法人データを取得
        $corporations = Corporation::where('corporation_name', 'LIKE', '%' . $corporationName . '%')
            ->where('corporation_num', 'LIKE', '%' . $corporationNumber . '%')
            ->get();

        return response()->json($corporations);
    }



    public function downloadCsv(Request $request)
    {
        // scopeFilterに渡すための絞り込み条件
        $filters = $request->only(['corporation_num', 'corporation_name', 'invoice_num']);

        // 並び替えの条件を取得
        $sortBy = session('sort_by', 'id');
        $sortDirection = session('sort_direction', 'asc');

        // モデルにビジネスロジックを寄せて、CSVファイルをダウンロード
        return Corporation::downloadCorporationCsv($filters, $sortBy, $sortDirection);
    }


    // public function exportCsv(Request $request)
    // {
    //     $filters = $request->only(['corporation_num', 'corporation_name']);
    //     ExportCorporationsCsv::dispatch($filters);

    //     // 生成されたファイル名を取得
    //     $filename = 'corporations_' . now()->format('YmdHis') . '.csv';

    //     // ダウンロードページにリダイレクト
    //     return redirect()->route('corporations.index')->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
    // }

    // public function downloadCsv($filename)
    // {
    //     $path = storage_path('app/' . $filename);
    //     return response()->download($path, $filename)->deleteFileAfterSend(true);
    // }





    public function showUploadForm()
    {
        return view('corporations.upload-form');
    }


    public function upload(CorporationUploadRequest $request)
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
            $errors[] = " 「法人番号」は必須です";
        } elseif (mb_strlen($row[0]) !== 6) {
            // size=6
            $errors[] = " 「法人番号」は6桁でなければなりません";
        }

        if ($operation === 'new' && Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = " 「法人番号」が重複しています";
        }
    
        if ($operation === 'update' && !Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = "更新対象の「法人番号」が存在しません";
        }


        // 桁数チェック
        if (mb_strlen($row[1]) > 100) {
            $errors[] = " 「法人名称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[2]) > 100) {
            $errors[] = " 「カナ名称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[3]) > 100) {
            $errors[] = " 「略称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[4]) > 1000) {
            $errors[] = " 「法人備考」は1000文字以下でなければなりません";
        }

        // 型チェック
        if (!is_string($row[1])) {
            $errors[] = " 「法人名称」は文字列である必要があります";
        }
        if (!is_string($row[2])) {
            $errors[] = " 「カナ名称」は文字列である必要があります";
        }
        if (!is_string($row[3])) {
            $errors[] = " 「略称」は文字列である必要があります";
        }
        if (!is_string($row[4])) {
            $errors[] = " 「法人備考」は文字列である必要があります";
        }
    

        return $errors;
    }
    
    // private function processRow(array $row, $operation)
    // {
    //     if ($existingRecord = Corporation::where('corporation_num', $row[0])->first()) {
    //         $existingRecord->update([
    //             'corporation_name' => $row[1],
    //             'corporation_kana_name' => $row[2],
    //             'corporation_short_name' => $row[3],
    //             'corporation_memo' => $row[4],
    //         ]);
    //     } elseif ($operation === 'new') {
    //         $corporation = new Corporation();
    //         $corporation->corporation_num = $row[0];
    //         $corporation->corporation_name = $row[1];
    //         $corporation->corporation_kana_name = $row[2];
    //         $corporation->corporation_short_name = $row[3];
    //         $corporation->corporation_memo = $row[4];
    //         $corporation->save();
    //     }
    // }
    private function processRow(array $row, $operation)
    {
        $corporationPrefectureId = $row[6];
        $prefectureId = Prefecture::where('id', $corporationPrefectureId)->first();
        if ($prefectureId) {
            $prefecture = $prefectureId->id;
        } else {
            $prefecture = null;
        }

        $data = [
            'corporation_num' => $row[0],
            'corporation_name' => $row[1],
            'corporation_kana_name' => $row[2],
            'corporation_short_name' => $row[3],
            'invoice_num' => $row[4],
            'corporation_post_code' => $row[5],
            'corporation_prefecture_id' => $prefecture,
            'corporation_address1' => $row[7],
            'corporation_memo' => $row[8],
        ];

        if ($operation === 'new') {
            // 新規登録の場合は$dataを保存
            Corporation::create($data);
        } elseif ($existingRecord = Corporation::where('corporation_num', $row[0])->first()) {
            // 既存レコードが存在する場合は更新
            $existingRecord->update($data);
        }
    }
}