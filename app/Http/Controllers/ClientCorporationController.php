<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientCorporationStoreRequest;
use App\Http\Requests\ClientCorporationUpdateRequest;
use App\Models\ClientCorporation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
// use Goodby\CSV\Import\Standard\InterpreterConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Jobs\ExportClientCorporationsCsv;

class ClientCorporationController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = 25; // １ページごとの表示件数

        //検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['s_clientcorporation_num', 's_clientcorporation_name', 's_clientcorporation_kana_name']);

        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$clientcorporationsに詰める。
        $clientcorporations = ClientCorporation::filter($filters) 
            ->withCount('clients')
            ->sortable()
            ->paginate($per_page);

        $count = $clientcorporations->total(); // 検索結果の件数を取得

        // $filtersの中には('clientcorporation_num','clientcorporation_name','clientcorporation_kana_name')が入ってる
        return view('clientcorporation.index', compact('clientcorporations', 'count') + $filters);
    }

    public function create()
    {
        return view('clientcorporation.create');
    }

    public function store(ClientCorporationStoreRequest $request)
    {
        // サブミットの制御用キーを生成
        $submitKey = 'submit_' . md5($request->url() . serialize($request->all()));

        // 重複サブミットのチェック
        if (Cache::has($submitKey)) {
            return redirect()->back()->with('error', '連続して登録することはできません。');
        }

        // データ保存(Model)
        $result = ClientCorporation::storeWithTransaction($request->except('clientcorporation_num'));

        if ($result) {
            // サブミット制御用キーを一定時間だけキャッシュに保存
            Cache::put($submitKey, true, 5); // 5分間の制御としています
            return redirect()->route('clientcorporation.index')->with('success', '登録しました');
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
        $clientcorporation = ClientCorporation::find($id);
        return view('clientcorporation.edit',compact('clientcorporation'));
    }

    public function update(ClientCorporationUpdateRequest $request,  string $id)
    {
        $clientCorporation = ClientCorporation::find($id);
        $clientCorporation->fill($request->all())->save();

        return redirect()->route('clientcorporation.edit',$id)->with('success','正常に更新されました。');
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

    // public function exportCsv(Request $request)
    // {
    //     $filters = $request->only(['s_clientcorporation_num', 's_clientcorporation_name', 's_clientcorporation_kana_name']);
    //     ExportClientCorporationsCsv::dispatch($filters);

    //     // 生成されたファイル名を取得
    //     $filename = 'clientcorporations_' . now()->format('YmdHis') . '.csv';

    //     return redirect()->back()->with('filename');
    //     // return view('clientcorporation.index', compact('filename'));
    //     // return back()->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
    // }

    public function exportCsv(Request $request)
{
    $filters = $request->only(['s_clientcorporation_num', 's_clientcorporation_name', 's_clientcorporation_kana_name']);
    ExportClientCorporationsCsv::dispatch($filters);

    // 生成されたファイル名を取得
    $filename = 'clientcorporations_' . now()->format('YmdHis') . '.csv';

    // ダウンロードページにリダイレクト
    return redirect()->route('clientcorporation.index')->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
}

    public function downloadCsv($filename)
    {
        $path = storage_path('app/' . $filename);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
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


    // private function parseCSVAndSaveToDatabase($csvPath)
    // {
    //     // CSVファイルの文字コードを自動判定
    //     $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win', true);
        
    //     $config = new LexerConfig();
    //     $config->setFromCharset($fromCharset);

    //     $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
    //     $lexer = new Lexer($config);
    //     $interpreter = new Interpreter();

    //      // CSV行をパースした際に実行する処理を定義
    //     $interpreter->addObserver(function (array $row) {
    //         $clientCorporation = new ClientCorporation();
    //         $clientCorporation->clientcorporation_num = $row[0];
    //         $clientCorporation->clientcorporation_name = $row[1];
    //         $clientCorporation->clientcorporation_kana_name = $row[2];
    //         $clientCorporation->clientcorporation_short_name = $row[3];
    //         $clientCorporation->save();
    //     });

    //     $lexer->parse($csvPath, $interpreter);
    // }


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
            $interpreter->addObserver(function (array $row) use ($operation) {
                // 登録済みかどうかを確認
                $existingRecord = ClientCorporation::where('clientcorporation_num', $row[0])->first();

                // 新規登録かつclientcorporation_numが重複している場合
                if ($operation === 'new' && ClientCorporation::where('clientcorporation_num', $row[0])->exists()) {
                    // バリデーションエラーがある場合
                    // エラーメッセージをセットしてリダイレクト
                    return redirect()->back()->withErrors(['clientcorporation_num' => 'すでに登録されている法人番号が含まれています。'])->withInput()->with('error','エラーがあります。');
                }

                if ($existingRecord && $operation === 'update') {
                    // 既存更新の処理
                    $existingRecord->update([
                        'clientcorporation_name' => $row[1],
                        'clientcorporation_kana_name' => $row[2],
                        'clientcorporation_short_name' => $row[3],
                    ]);
                } elseif ($operation === 'new') {

                    // 新規登録の処理
                    $clientCorporation = new ClientCorporation();
                    $clientCorporation->clientcorporation_num = $row[0];
                    $clientCorporation->clientcorporation_name = $row[1];
                    $clientCorporation->clientcorporation_kana_name = $row[2];
                    $clientCorporation->clientcorporation_short_name = $row[3];
                    $clientCorporation->save();
                }
            });

            $lexer->parse($csvPath, $interpreter);

            // トランザクションコミット
            DB::commit();
        } catch (\Exception $e) {
            // エラー発生時の処理（例: ログ出力、エラーメッセージの設定など）
            
            // トランザクションロールバック
            DB::rollBack();

            // 例外を再スロー
            throw $e;
        }
    }
}