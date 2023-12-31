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
        $clientCorporation = ClientCorporation::find($id);
        $clientCorporation->delete();

        return redirect()->back()->with('success','正常に削除されました');
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
            $clientCorporation = new ClientCorporation();
            $clientCorporation->clientcorporation_num = $row[0];
            $clientCorporation->clientcorporation_name = $row[1];
            $clientCorporation->clientcorporation_kana_name = $row[2];
            $clientCorporation->clientcorporation_short_name = $row[3];
            $clientCorporation->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }

}
