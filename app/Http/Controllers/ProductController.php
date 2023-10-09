<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;//add
use App\Models\Department;//add
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
        $per_page = 100;
        $users = User::all();
        $productSeriess = ProductSeries::all();
        $productTypes = ProductType::all();
        $productSplitTypes = ProductSplitType::all();
        $departments = Department::all();

        // 検索formに入力された値を取得
        $productCode = $request->product_code;
        $productName = $request->product_name;
        $department = $request->department_id;
        $isStopSelling = $request->is_stop_selling;
        $productSeries = $request->product_series; 
        $productType = $request->product_type; 
        $productSplitType = $request->product_split_type; 

        //検索Query
        // $query = Product::query();
        $query = Product::with(['department', 'productSplitType', 'productSeries'])->sortable()->orderBy('product_code', 'asc');

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

        $count = $query->count(); // 検索結果の総数を取得
        // $products = $query->with(['department','productSplitType','productSeries'])->sortable()->orderBy('product_code','asc')->paginate($per_page);
        $products = $query->paginate($per_page);

        return view('product.index',compact('products','count','users','productCode','productName','productSeriess','productTypes','productSplitTypes','departments'));
    }

    public function create()
    {
        $users = User::all();
        $departments = Department::all(); //管轄事業部
        $productMakers = ProductMaker::all(); //製品メーカ
        $productSeries = ProductSeries::all(); //製品シリーズ
        $productTypes = ProductType::all(); //製品種別
        $productSplitTypes = ProductSplitType::all(); //製品内訳種別

        return view('product.create',compact('users','departments','productMakers','productSeries','productTypes','productSplitTypes'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // バリデーション
        $request->validate([
            'product_maker_id' => 'required',
            'department_id' => 'required',
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
        $departmentId = $request->department_id;
        $productTypeId = $request->product_type_id; 
        $productSplitTypeId = $request->product_split_type_id; 

        // 登録処理（トランザクションを開始）
        DB::beginTransaction();
        try {

            // 製品コードを生成
            $productMaker = ProductMaker::find($productMakerId);
            $department = Department::find($departmentId);
            $productType = ProductType::find($productTypeId);
            $productSplitType = ProductSplitType::find($productSplitTypeId);

            $productCode = Product::generateProductCode($productMaker, $department, $productType, $productSplitType);
            
            $product = new Product();
            $product->product_maker_id = $productMakerId;
            $product->department_id = $departmentId;
            $product->product_type_id = $productTypeId;
            $product->product_split_type_id = $productSplitTypeId;
            $product->product_series_id = $request->product_series_id;
            $product->product_name = $request->product_name;
            $product->product_short_name = $request->product_short_name;
            $product->unit_price = $request->unit_price;
            $product->product_memo1 = $request->product_memo1;
            $product->product_memo2 = $request->product_memo2;
            $product->is_stop_selling = $request->is_stop_selling;
            $product->is_listed = $request->is_listed;
            $product->product_code = $productCode;
            $product->save();

            DB::commit();

        // 成功時の処理
        return redirect()->route('product.index')->with('message', '登録しました。');

        } catch (\Exception $e) {
        // トランザクションをロールバック
            DB::rollback();
        // エラー時の処理
            return redirect()->back()->with('message', '登録に失敗しました。');
            }
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $users = User::all();
        $departments = Department::all(); //管轄事業部
        $productMakers = ProductMaker::all(); //製品メーカ
        $productSeries = ProductSeries::all(); //製品シリーズ
        $productTypes = ProductType::all(); //製品種別
        $productSplitTypes = ProductSplitType::all(); //製品内訳種別

        return view('product.edit',compact('users','departments','productMakers','productSeries','productTypes','productSplitTypes','product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        // バリデーション処理
        $inputs = $request->validate([

        ]);

        // データ登録処理

        $product->product_maker_id = $request->product_maker_id;
        $product->department_id = $request->department_id;
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

        return redirect()->route('product.edit',$id)->with('message', '変更しました');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('product.index')->with('message', '削除しました');
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
    //         $departmentId = $row[1];
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
    //         $product->department_id = $departmentId;
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
    //         $department = Department::find($departmentId);
    //         $productType = ProductType::find($productTypeId);
    //         $productSplitType = ProductSplitType::find($productSplitTypeId);

    //         // Product::generateProductCode() メソッドを呼び出し、製品コードを生成
    //         $productCode = Product::generateProductCode($productMaker, $department, $productType, $productSplitType);
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
        $department = Department::where('prefix_code', $prefixCode)->first();
        $productType = ProductType::where('type_code', $typeCode)->first();
        $productSplitType = ProductSplitType::where('split_type_code', $splitTypeCode)->first();
        $productSeries = ProductSeries::where('series_code', $seriesCode)->first();
    
        // Product::generateProductCode() メソッドを呼び出し、製品コードを生成
        $productCode = Product::generateProductCode($productMaker, $department, $productType, $productSplitType);
    
        // CSVファイルから取得したデータを使って Product モデルにデータを登録
        $product = new Product();
        $product->product_maker_id = $productMaker->id;
        $product->department_id = $department->id;
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
}
