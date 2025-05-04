<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;//add
use App\Models\Affiliation2;//add
use App\Models\ProductMaker;//add
use App\Models\ProductSeries;//add
use App\Models\ProductType;//add
use App\Models\ProductSplitType;//add
use Illuminate\Support\Str;//add
use Illuminate\Support\Facades\DB;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\InterpreterConfig;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');
        $productSeriess = ProductSeries::all();
        $productTypes = ProductType::all();
        $productSplitTypes = ProductSplitType::all();
        $affiliation2s = Affiliation2::all();

        // 検索formに入力された値を取得
        $productCode = $request->product_code;
        $productName = $request->product_name;
        $affiliation2 = $request->affiliation2_id;
        $isStopSelling = $request->is_stop_selling;
        $productSeries = $request->product_series; 
        $productType = $request->product_type; 
        $productSplitType = $request->product_split_type; 

        //検索Query
        $query = Product::with(['affiliation2', 'productSplitType', 'productSeries', 'productsplittype'])->sortable()->orderBy('product_code', 'asc');

        if(!empty($productCode))
        {
            $query->where('product_code', 'like', '%' . $productCode . '%');
        }

        if(!empty($productName))
        {
            $spaceConversion = mb_convert_kana($productName, 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) 
            {
                $query->where('product_name', 'like', '%' . $productName . '%');
            }
        }

        $products = $query->paginate($perPage);
        $count = $products->total(); // 検索結果の総数を取得

        return view('product.index',compact('products', 'count', 'productCode', 'productName', 'productSeriess', 'productTypes', 'productSplitTypes', 'affiliation2s'));
    }

    public function create()
    {
        $users = User::all();
        $affiliation2s = Affiliation2::all(); //管轄事業部
        $productMakers = ProductMaker::all(); //製品メーカ
        $productSeries = ProductSeries::all(); //製品シリーズ
        $productTypes = ProductType::all(); //製品種別
        $productSplitTypes = ProductSplitType::all(); //製品内訳種別

        return view('product.create',compact('users','affiliation2s','productMakers','productSeries','productTypes','productSplitTypes'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // バリデーション
        $request->validate([
            'product_maker_id' => 'required',
            'affiliation2_id' => 'required',
            'product_type_id' => 'required',
            'product_split_type_id' => 'required',
            'product_series_id' => 'required',
            'product_name' => 'required',
            'product_short_name' => 'required',
            'unit_price' => 'required',
            'is_stop_selling' => 'required',
            'is_listed' => 'required'
        ]);

        //この後の登録処理で使用する値を変数に格納する。
        $productMakerId = $request->product_maker_id;
        $affiliation2Id = $request->affiliation2_id;
        $productTypeId = $request->product_type_id; 
        $productSplitTypeId = $request->product_split_type_id; 

        // 製品コードを生成
        $productMaker = ProductMaker::find($productMakerId);
        $affiliation2 = Affiliation2::find($affiliation2Id);
        $productType = ProductType::find($productTypeId);
        $productSplitType = ProductSplitType::find($productSplitTypeId);

        $productCode = Product::generateProductCode($productMaker, $affiliation2, $productType, $productSplitType);
        
        $product = new Product();
        $product->product_maker_id = $productMakerId;
        $product->affiliation2_id = $affiliation2Id;
        $product->product_type_id = $productTypeId;
        $product->product_split_type_id = $productSplitTypeId;
        $product->product_series_id = $request->product_series_id;
        $product->product_name = $request->product_name;
        $product->product_short_name = $request->product_short_name;
        $product->unit_price = filter_var($request->unit_price, FILTER_SANITIZE_NUMBER_INT);
        $product->product_memo1 = $request->product_memo1;
        $product->product_memo2 = $request->product_memo2;
        $product->is_stop_selling = $request->is_stop_selling;
        $product->is_listed = $request->is_listed;
        $product->product_code = $productCode;
        $product->save();

        // 成功時の処理
        return redirect()->route('products.index')->with('success', '正常に登録しました');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $users = User::all();
        $affiliation2s = Affiliation2::all(); //管轄事業部
        $productMakers = ProductMaker::all(); //製品メーカ
        $productSeries = ProductSeries::all(); //製品シリーズ
        $productTypes = ProductType::all(); //製品種別
        $productSplitTypes = ProductSplitType::all(); //製品内訳種別

        return view('product.edit',compact('users','affiliation2s','productMakers','productSeries','productTypes','productSplitTypes','product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        // バリデーション処理
        $inputs = $request->validate([

        ]);

        // データ登録処理

        $product->product_maker_id = $request->product_maker_id;
        $product->affiliation2_id = $request->affiliation2_id;
        $product->product_type_id = $request->product_type_id;
        $product->product_split_type_id = $request->product_split_type_id;
        $product->product_series_id = $request->product_series_id;
        $product->product_name = $request->product_name;
        $product->product_short_name = $request->product_short_name;
        $product->unit_price = $request->unit_price;
        $product->product_memo1 = $request->product_memo1;
        $product->product_memo2 = $request->product_memo2;
        $product->is_stop_selling = $request->is_stop_selling;
        $product->is_listed = $request->is_listed;
        $product->product_code = $request->product_code;
        $product->save();

        return redirect()->route('products.edit',$id)->with('success', '正常に変更しました');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '正常に削除しました');
    }


    public function upload(Request $request)
    {
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

    // $interpreter->addObserver(function (array $row) {

    //         Log::info('CSV Row Data:', $row);

    //         // CSV ファイルの各列から値を取得して変数に格納する
    //         $productMakerId = $row[0];
    //         $affiliation2Id = $row[1];
    //         $productTypeId = $row[2];
    //         $productSplitTypeId = $row[3];
    //         $productSeries = $row[4];
    //         $productName = $row[5];
    //         $productShortName = $row[6];
    //         $unitPrice = $row[7];
    //         $isStopSelling = $row[8];
    //         $isListed = $row[9];
    //         $productMemo1 = $row[10];
    //         $productMemo2 = $row[11];

    //      // CSV行をパースした際に実行する処理を定義
    //         $product = new Product();
    //         $product->product_maker_id = $productMakerId;
    //         $product->affiliation2_id = $affiliation2Id;
    //         $product->product_type_id = $productTypeId;
    //         $product->product_split_type_id = $productSplitTypeId;
    //         $product->product_series_id = $productSeries;
    //         $product->product_name = $productName;
    //         $product->product_short_name = $productShortName;
    //         $product->unit_price = $unitPrice;
    //         $product->is_stop_selling = $isStopSelling;
    //         $product->is_listed = $isListed;
    //         $product->product_memo1 = $productMemo1;
    //         $product->product_memo2 = $productMemo2;

    //         $productMaker = ProductMaker::find($productMakerId);
    //         $affiliation2 = Affiliation2::find($affiliation2Id);
    //         $productType = ProductType::find($productTypeId);
    //         $productSplitType = ProductSplitType::find($productSplitTypeId);

    //         // Product::generateProductCode() メソッドを呼び出し、製品コードを生成
    //         $productCode = Product::generateProductCode($productMaker, $affiliation2, $productType, $productSplitType);
    //         $product->product_code = $productCode; // 生成した製品コードを設定

    //         $product->save();
    //     });

    //     $lexer->parse($csvPath, $interpreter);
    // }
    $interpreter->addObserver(function (array $row) {
        Log::info('CSV Row Data:', $row);
    
        // CSV ファイルの各列から値を取得して変数に格納する
        $makerCode = $row[0]; // CSVファイルからmaker_codeを取得
        $prefixCode = $row[1]; // CSVファイルからprefix_codeを取得
        $typeCode = $row[2]; // CSVファイルからtype_codeを取得
        $splitTypeCode = $row[3]; // CSVファイルからsplit_type_codeを取得
        $seriesCode = $row[4];
    
        // 各外部テーブルから関連データを取得
        $productMaker = ProductMaker::where('maker_code', $makerCode)->first();
        $affiliation2 = Affiliation2::where('affiliation2_prefix', $prefixCode)->first();
        $productType = ProductType::where('type_code', $typeCode)->first();
        $productSplitType = ProductSplitType::where('split_type_code', $splitTypeCode)->first();
        $productSeries = ProductSeries::where('series_code', $seriesCode)->first();
    
        // Product::generateProductCode() メソッドを呼び出し、製品コードを生成
        $productCode = Product::generateProductCode($productMaker, $affiliation2, $productType, $productSplitType);
    
        // CSVファイルから取得したデータを使って Product モデルにデータを登録
        $product = new Product();
        $product->product_maker_id = $productMaker->id;
        $product->affiliation2_id = $affiliation2->id;
        $product->product_type_id = $productType->id;
        $product->product_split_type_id = $productSplitType->id;
        $product->product_series_id = $productSeries->id;
        $product->product_name = $row[5];
        $product->product_short_name = $row[6];
        $product->unit_price = $row[7];
        $product->is_stop_selling = $row[8];
        $product->is_listed = $row[9];
        $product->product_memo1 = $row[10];
        $product->product_memo2 = $row[11];
        $product->product_code = $productCode;
        $product->save();
    });

    $lexer->parse($csvPath, $interpreter);
}
public function getSplitTypes($productTypeId)
{
    $splitTypes = ProductSplitType::where('product_type_id', $productTypeId)->get();
    return response()->json($splitTypes);
}


    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $query = Product::query()->orderBy('product_split_type_id', 'asc')
            ->where('is_listed', '=',  '1');
    
        // 検索条件が指定されている場合のみクエリに追加
        if ($request->filled('productName')) {
            $query->where('product_name', 'LIKE', '%' . $request->input('productName') . '%');
        }
        if ($request->filled('productSeriesId')) {
            $query->where('product_series_id', 'LIKE', '%' . $request->input('productSeriesId') . '%');
        }
        if ($request->filled('productSplitTypeId')) {
            $query->where('product_split_type_id', '=', $request->input('productSplitTypeId'));
        }
    
        $products = $query->with('productSplitType', 'affiliation2', 'productSeries')->get();
    
        return response()->json($products);
    }


    public function showUploadForm()
    {
        return view('product.upload-form');
    }

    
}
