<?php

namespace App\Http\Controllers;

use App\Models\ClientCorporation;
use Illuminate\Http\Request;
use App\Models\Client; //add
use illuminate\pagination\paginator; //add
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\InterpreterConfig;

class ClientCorporationController extends Controller
{
    public function index(Request $request)//検索用にrequestを受取る
    {
        $per_page = 50; // １ページごとの表示件数

        //検索フォームに入力された値を取得
        $clientcorporation_num = $request->input('clientcorporation_num');
        $clientcorporation_name = $request->input('clientcorporation_name');
        $clientcorporation_kana_name = $request->input('clientcorporation_kana_name');

        //検索Query
        $query = ClientCorporation::query();

        //もし法人番号がセットされていれば
        if(!empty($clientcorporation_num))
        {
            $query->where('clientcorporation_num','like',"%{$clientcorporation_num}");
            // $query->where('clientcorporation_num','=',$clientcorporation_num);
        }

        //もし法人名称がセットされていれば
        if(!empty($clientcorporation_name))
        {
            $spaceConversion = mb_convert_kana($clientcorporation_name, 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('clientcorporation_name', 'like', "%{$clientcorporation_name}%");
            }
        }
        
        //もし法人カナ名称がセットされていれば
        if(!empty($clientcorporation_kana_name))
        {
            $query->where('clientcorporation_kana_name','like',"%{$clientcorporation_kana_name}%");
        }

        $count = $query->count(); // 検索結果の総数を取得
        $clientcorporations = $query->sortable()->paginate($per_page);

        return view('clientcorporation.index',compact('clientcorporations','clientcorporation_num','clientcorporation_name','clientcorporation_kana_name','count'));
    }

    public function create()
    {
        return view('clientcorporation.create');
    }

    public function store(Request $request)
    {
        $inputs=$request->validate([
            'clientcorporation_num'=>'|min:6|max:6|unique:client_corporations',
            'clientcorporation_name'=>'required|max:1024',
            'clientcorporation_kana_name'=>'required|max:1024'
        ]);

        $data = $request->except('clientcorporation_num');

        $clientcorporation = new ClientCorporation();
        $result = $clientcorporation->storeWithTransaction($data);

        if ($result) {
            return redirect()->route('clientcorporation.index')->with('success', '登録しました');
        } else {
            return back()->with('error', '登録に失敗しました。');
        }

        // $clientcorporation->clientcorporation_num=$request->clientcorporation_num;
        $clientcorporation->clientcorporation_name = $request->clientcorporation_name;
        $clientcorporation->clientcorporation_kana_name = $request->clientcorporation_kana_name;
        $clientcorporation->save();
        return redirect()->route('clientcorporation.create')->with('message', '登録しました');
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

    public function update(Request $request,  string $id)
    {
        $clientCorporation = ClientCorporation::find($id);

        $inputs=$request->validate([
            // 'clientcorporation_num'=>'|min:6|max:6|unique:client_corporations',
            'clientcorporation_name'=>'required|max:1024',
            'clientcorporation_kana_name'=>'required|max:1024'
        ]);

        $clientCorporation->clientcorporation_name = $request->clientcorporation_name;
        $clientCorporation->clientcorporation_kana_name = $request->clientcorporation_kana_name;

        $clientCorporation->save();
        return redirect()->route('clientcorporation.edit',$id)->with('message','更新しました');
    }

    public function destroy(ClientCorporation $clientCorporation)
    {
        //
    }

    //モーダル用の非同期検索ロジック
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
        $config = new LexerConfig();
        $config->setToCharset("UTF-8");
        $config->setFromCharset("sjis-win");
        $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
        $lexer = new Lexer($config);
        $interpreter = new Interpreter();

         // CSV行をパースした際に実行する処理を定義
        $interpreter->addObserver(function (array $row) {
            $clientCorporation = new ClientCorporation();
            $clientCorporation->clientcorporation_num = $row[0];
            $clientCorporation->clientcorporation_name = $row[1];
            $clientCorporation->clientcorporation_kana_name = $row[2];
            $clientCorporation->save();
        });


        $lexer->parse($csvPath, $interpreter);
    }


}
