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
use Illuminate\Support\Facades\Session;

class CorporationController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
        {
        // 検索条件を取得してセッションに保存
        Session::put('search_params', $request->all());

        $perPage = 100; // １ページごとの表示件数

        // 検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['corporation_num', 'corporation_name']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $CorporationNum = $filters['corporation_num'] ?? null;
        $CorporationName = $filters['corporation_name'] ?? null;

        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $corporations = Corporation::filter($filters) 
            ->withCount('clients')
            ->sortable()
            ->paginate($perPage);

        $count = $corporations->total(); // 検索結果の件数を取得

        return view('corporations.index', compact('corporations', 'count' ,'filters', 'CorporationNum', 'CorporationName'));
    }

    public function create()
    {
        return view('corporations.create');
    }

    public function store(CorporationStoreRequest $request)
    {
        $result = Corporation::storeWithTransaction($request->except('corporation_num'));

        if ($result) {
            return redirect()->route('corporations.index')->with('success', '正常に登録しました');
        } else {
            return back()->with('error', '登録に失敗しました。');
        }
    }

    public function show(Corporation $Corporation)
    {
        //
    }

    public function edit(string $id)
    {
        $corporation = Corporation::find($id);
        return view('corporations.edit',compact('corporation'));
    }

    public function update(CorporationUpdateRequest $request, string $id)
    {
        try {
            // モデルを見つけて、存在するか確認
            $corporation = Corporation::findOrFail($id);

            // データを更新
            $corporation->fill($request->all())->save();
            return redirect()->route('corporations.edit', $id)->with('success', '正常に更新されました');
            
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
            // $Corporation->delete();
            // return redirect()->back()->with('success', '正常に削除されました');

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







    // CSVで検索結果をダウンロードするメソッド
    public function downloadCsv(Request $request)
    {
        // 検索条件を取得
        $filters = $request->only(['corporation_num', 'corporation_name']);

        // 検索結果の顧客法人データを取得
        $corporations = Corporation::with(['createdBy', 'updatedBy'])
        ->filter($filters)
        ->withCount('clients')
        ->get();


        // CSVのヘッダー行を作成
        $csvHeader = ['ID', '法人番号', '法人正式名', '法人正式カナ名', '法人略称', '法人備考', '顧客数', '作成者', '作成日時', '更新者', '更新日時'];

        // CSVの内容を格納する配列を初期化
        $csvData = [];

        // 顧客法人データをCSVデータに変換
        foreach ($corporations as $corporation) {
            $csvData[] = [
                $corporation->id,
                $corporation->corporation_num,
                $corporation->corporation_name,
                $corporation->corporation_kana_name,
                $corporation->corporation_short_name,
                $corporation->memo,
                $corporation->clients_count,
                $corporation->createdBy->name,
                $corporation->created_at,
                $corporation->updatedBy->name,
                $corporation->updated_at,
            ];
        }

        // CSVファイルの名前を生成
        $fileName = '法人データ_' . date('YmdHis') . '.csv';
        // $fileName = 'corporation_data_' . date('YmdHis') . '.csv';

        // CSVファイルを生成してダウンロード
        return $this->downloadCsvFile($fileName, $csvHeader, $csvData);
    }

    // CSVファイルを生成してダウンロード
    private function downloadCsvFile($fileName, $csvHeader, $csvData)
    {
        ob_start();
        $output = fopen('php://output', 'w');
    
        // BOMなしでUTF-8エンコーディング
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
        // ヘッダー行を書き込む
        fputcsv($output, $csvHeader);
    
        // データを書き込む
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
    
        fclose($output);
    
        $csvContent = ob_get_clean();
    
        // レスポンスを生成してダウンロード
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
    
        return response()->make($csvContent, 200, $headers);
    }


//     public function exportCsv(Request $request)
// {
//     $filters = $request->only(['corporation_num', 'corporation_name']);
//     ExportCorporationsCsv::dispatch($filters);

//     // 生成されたファイル名を取得
//     $filename = 'corporations_' . now()->format('YmdHis') . '.csv';

//     // ダウンロードページにリダイレクト
//     return redirect()->route('corporations.index')->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
// }

//     public function downloadCsv($filename)
//     {
//         $path = storage_path('app/' . $filename);

//         return response()->download($path, $filename)->deleteFileAfterSend(true);
//     }





    public function showUploadForm()
    {
        return view('corporations.upload-form');
    }


    public function upload(CorporationUploadRequest $request)
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
    
        if (count($row) !== 5) {
            $errors[] = "$lineNumber 行目：列数が5ではない行があります";
        }

        // 法人番号($row[0])に関して
        if (empty($row[0])) {
            // required
            $errors[] = "$lineNumber 行目：「法人番号」は必須です";
        } elseif (mb_strlen($row[0]) !== 6) {
            // size=6
            $errors[] = "$lineNumber 行目：法人番号は6桁でなければなりません";
        }

        if ($operation === 'new' && Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = "$lineNumber 行目：「法人番号」が重複しています";
        }
    
        if ($operation === 'update' && !Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = "$lineNumber 行目：更新対象の「法人番号」が存在しません";
        }


        // 桁数チェック
        if (mb_strlen($row[1]) > 100) {
            $errors[] = "$lineNumber 行目：法人名称は100文字以下でなければなりません";
        }
        if (mb_strlen($row[2]) > 100) {
            $errors[] = "$lineNumber 行目：カナ名称は100文字以下でなければなりません";
        }
        if (mb_strlen($row[3]) > 100) {
            $errors[] = "$lineNumber 行目：略称は100文字以下でなければなりません";
        }
        if (mb_strlen($row[4]) > 1000) {
            $errors[] = "$lineNumber 行目：法人備考は1000文字以下でなければなりません";
        }

        // 型チェック
        if (!is_string($row[1])) {
            $errors[] = "$lineNumber 行目：法人名称は文字列である必要があります";
        }
        if (!is_string($row[2])) {
            $errors[] = "$lineNumber 行目：カナ名称は文字列である必要があります";
        }
        if (!is_string($row[3])) {
            $errors[] = "$lineNumber 行目：略称は文字列である必要があります";
        }
        if (!is_string($row[4])) {
            $errors[] = "$lineNumber 行目：法人備考は文字列である必要があります";
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
    //             'memo' => $row[4],
    //         ]);
    //     } elseif ($operation === 'new') {
    //         $corporation = new Corporation();
    //         $corporation->corporation_num = $row[0];
    //         $corporation->corporation_name = $row[1];
    //         $corporation->corporation_kana_name = $row[2];
    //         $corporation->corporation_short_name = $row[3];
    //         $corporation->memo = $row[4];
    //         $corporation->save();
    //     }
    // }
    private function processRow(array $row, $operation)
    {
        $data = [
            'corporation_num' => $row[0],
            'corporation_name' => $row[1],
            'corporation_kana_name' => $row[2],
            'corporation_short_name' => $row[3],
            'memo' => $row[4],
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