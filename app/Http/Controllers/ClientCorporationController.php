<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientCorporationStoreRequest;
use App\Http\Requests\ClientCorporationUpdateRequest;
use App\Models\ClientCorporation;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Validator;
// use Goodby\CSV\Import\Standard\InterpreterConfig;
use Illuminate\Support\Facades\Response;
use App\Jobs\ExportClientCorporationsCsv;


class ClientCorporationController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $perPage = 100; // １ページごとの表示件数

        // 検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['clientcorporation_num', 'clientcorporation_name']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $clientCorporationNum = $filters['clientcorporation_num'] ?? null;
        $clientCorporationName = $filters['clientcorporation_name'] ?? null;

        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$clientcorporationsに詰める
        $clientcorporations = ClientCorporation::filter($filters) 
            ->withCount('clients')
            ->sortable()
            ->paginate($perPage);

        $count = $clientcorporations->total(); // 検索結果の件数を取得

        return view('clientcorporation.index', compact('clientcorporations', 'count' ,'filters', 'clientCorporationNum', 'clientCorporationName'));
    }

    public function create()
    {
        return view('clientcorporation.create');
    }

    public function store(ClientCorporationStoreRequest $request)
    {
        $result = ClientCorporation::storeWithTransaction($request->except('clientcorporation_num'));

        if ($result) {
            // $request->session()->forget('success'); // フラッシュメッセージを削除
            return redirect()->route('clientcorporation.index')->with('success', '正常に登録しました');
        } else {
            return back()->with('error', '登録に失敗しました。');
        }
    }

    public function show(ClientCorporation $clientCorporation)
    {
        //
    }

    public function edit(string $id)
    {
        $clientCorporation = ClientCorporation::find($id);
        return view('clientcorporation.edit',compact('clientCorporation'));
    }

    public function update(ClientCorporationUpdateRequest $request, string $id)
    {
        try {
            // モデルを見つけて、存在するか確認
            $clientCorporation = ClientCorporation::findOrFail($id);

            // データを更新
            $clientCorporation->fill($request->all())->save();
            return redirect()->route('clientcorporation.edit', $id)->with('success', '正常に更新されました');
            
        } catch (ModelNotFoundException $e) {
            // モデルが見つからない場合のエラーメッセージ
            return redirect()->back()->with('error', '指定されたデータが見つかりませんでした');
        }
    }

    public function destroy(string $id)
    {
        try {
            // 子データが存在するか確認
            $clientCorporation = ClientCorporation::with('clients')->findOrFail($id);
    
            // 子データが存在する場合は削除を中止
            if ($clientCorporation->clients()->exists()) {
                return redirect()->back()->with('error', '顧客データが存在するため、削除できません');
            }
    
            // 子データが存在しない場合は削除を実行
            $clientCorporation->delete();
            return redirect()->back()->with('success', '正常に削除されました');

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
        $corporations = ClientCorporation::where('clientcorporation_name', 'LIKE', '%' . $corporationName . '%')
            ->where('clientcorporation_num', 'LIKE', '%' . $corporationNumber . '%')
            ->get();

        return response()->json($corporations);
    }







    // CSVで検索結果をダウンロードするメソッド
    public function downloadCsv(Request $request)
    {
        // 検索条件を取得
        $filters = $request->only(['clientcorporation_num', 'clientcorporation_name']);

        // 検索結果の顧客法人データを取得
        $clientcorporations = ClientCorporation::with(['createdBy', 'updatedBy'])
        ->filter($filters)
        ->withCount('clients')
        ->get();

        // CSVのヘッダー行を作成
        $csvHeader = ['ID', '法人番号', '法人正式名', '法人正式カナ名', '法人略称', '法人備考', '顧客数', '作成者', '作成日時', '更新者', '更新日時'];

        // CSVの内容を格納する配列を初期化
        $csvData = [];

        // 顧客法人データをCSVデータに変換
        foreach ($clientcorporations as $clientcorporation) {
            $csvData[] = [
                $clientcorporation->id,
                $clientcorporation->clientcorporation_num,
                $clientcorporation->clientcorporation_name,
                $clientcorporation->clientcorporation_kana_name,
                $clientcorporation->clientcorporation_short_name,
                $clientcorporation->memo,
                $clientcorporation->clients_count,
                $clientcorporation->createdBy->name,
                $clientcorporation->created_at,
                $clientcorporation->updatedBy->name,
                $clientcorporation->updated_at,
            ];
        }

        // CSVファイルの名前を生成
        $fileName = '法人データ_' . date('YmdHis') . '.csv';
        // $fileName = 'clientcorporation_data_' . date('YmdHis') . '.csv';

        // CSVファイルを生成してダウンロード
        return $this->downloadCsvFile($fileName, $csvHeader, $csvData);
    }

    // CSVファイルを生成してダウンロード
    private function downloadCsvFile($fileName, $header, $data)
    {
        ob_start();
        $output = fopen('php://output', 'w');
    
        // BOMなしでUTF-8エンコーディング
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
        // ヘッダー行を書き込む
        fputcsv($output, $header);
    
        // データを書き込む
        foreach ($data as $row) {
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
//     $filters = $request->only(['clientcorporation_num', 'clientcorporation_name']);
//     ExportClientCorporationsCsv::dispatch($filters);

//     // 生成されたファイル名を取得
//     $filename = 'clientcorporations_' . now()->format('YmdHis') . '.csv';

//     // ダウンロードページにリダイレクト
//     return redirect()->route('clientcorporation.index')->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
// }

//     public function downloadCsv($filename)
//     {
//         $path = storage_path('app/' . $filename);

//         return response()->download($path, $filename)->deleteFileAfterSend(true);
//     }





    public function showUploadForm()
    {
        return view('clientcorporation.upload-form');
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

        // ラジオボタンの選択状態を確認
        $radioOption = $request->input('inline-radio-group');

        // 分岐処理
        if ($radioOption === 'new') {
            // 新規登録の処理
            $this->parseCSVAndSaveToDatabase($csvPath, 'new');
        } elseif ($radioOption === 'update') {
            // 既存更新の処理
            $this->parseCSVAndSaveToDatabase($csvPath, 'update');
        } else {
            // その他の処理（エラー処理など）
            return redirect()->back()->with('error', '選択された処理が不明です。');
        }
        
        // CSVデータのパースとデータベースへの登録処理
        // $this->parseCSVAndSaveToDatabase($csvPath);

        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', '正常にアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath, $operation)
    {
        // CSVファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset);

        $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
        $lexer = new Lexer($config);

        // トランザクション開始
        DB::beginTransaction();

        try {
            // CSV行をパースした際に実行する処理を定義
            $interpreter = new Interpreter();

            // 登録したレコード数をカウントする変数
            $recordCount = 0;
            
            $interpreter->addObserver(function (array $row) use ($operation, &$recordCount) {
                // 登録済みかどうかを確認
                $existingRecord = ClientCorporation::where('clientcorporation_num', $row[0])->first();

                // 新規登録かつclientcorporation_numが重複している場合
                if ($operation === 'new' && ClientCorporation::where('clientcorporation_num', $row[0])->exists()) {
                    // バリデーションエラーがある場合
                    // エラーメッセージをセットしてリダイレクト
                    return redirect()->back()->withErrors(['clientcorporation_num' => 'すでに登録されている法人番号が含まれています。'])->withInput()->with('error','エラーがあります。');
                }
                // 既存更新かつclientcorporation_numが存在していない場合
                if ($operation === 'update' && !ClientCorporation::where('clientcorporation_num', $row[0])->exists()) {
                    // バリデーションエラーがある場合
                    // エラーメッセージをセットしてリダイレクト
                    return redirect()->back()->withErrors(['clientcorporation_num' => '更新対象の法人番号が見つかりません。'])->withInput()->with('error','エラーがあります。');
                }

                if ($existingRecord && $operation === 'update') {
                    // 既存更新の処理
                    $existingRecord->update([
                        'clientcorporation_name' => $row[1],
                        'clientcorporation_kana_name' => $row[2],
                        'clientcorporation_short_name' => $row[3],
                        'memo' => $row[4],
                    ]);
                } elseif ($operation === 'new') {

                    // 新規登録の処理
                    $clientCorporation = new ClientCorporation();
                    $clientCorporation->clientcorporation_num = $row[0];
                    $clientCorporation->clientcorporation_name = $row[1];
                    $clientCorporation->clientcorporation_kana_name = $row[2];
                    $clientCorporation->clientcorporation_short_name = $row[3];
                    $clientCorporation->memo = $row[4];
                    $clientCorporation->save();

                    // 登録したレコード数をインクリメント
                    $recordCount++;
                }
            });

            $lexer->parse($csvPath, $interpreter);

                // フラッシュメッセージに登録したレコード数を含むメッセージをセット
            $flashMessage = $recordCount > 0
            ? "正常にアップロードしました。新規登録件数: {$recordCount} 件"
            : '正常にアップロードしました。新しいデータはありません。';

            // トランザクションコミット
            DB::commit();

            // フラッシュメッセージをセットしてリダイレクト
            return redirect()->back()->with('success', $flashMessage);

        } catch (\Exception $e) {
            // エラー発生時の処理（例: ログ出力、エラーメッセージの設定など）
            
            // トランザクションロールバック
            DB::rollBack();

            // 例外を再スロー
            throw $e;
        }
    }
}