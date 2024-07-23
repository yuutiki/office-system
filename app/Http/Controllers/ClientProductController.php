<?php

namespace App\Http\Controllers;

use App\Models\Affiliation2;
use App\Models\ClientProduct;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductSeries;
use App\Models\ProductSplitType;
use App\Models\ProductVersion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientProductController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        $users = User::all();
        $departments = Affiliation2::all(); //管轄事業部
        $productSeries = ProductSeries::all();
        $productVersions = ProductVersion::orderby('version_code','desc')->get();
        // $productSplitTypes = ProductSplitType::all();
        $productSplitTypes = ProductSplitType::leftJoin('products', 'product_split_types.id', '=', 'products.product_split_type_id')
        ->where('products.is_listed', 1)
        ->whereNotNull('products.product_split_type_id') // 製品種別が存在する場合のみ取得
        ->select('product_split_types.*')
        ->distinct()
        ->get();

        // セッションからclient_numとclient_nameを取得
        $clientNum = Session::get('selected_client_num');
        $clientName = Session::get('selected_client_name');
        $clientId = Session::get('selected_client_id');

        $client = $clientId;

        return view('client-product.create',compact('departments','users','productSeries','productVersions','productSplitTypes','clientNum','clientName','clientId', 'client'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
            'product_version_id' => 'required|exists:product_versions,id',
            'is_customized' => 'boolean',
            'is_contracted' => 'boolean',
        ]);

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $request->client_num)->first();
        $clientId = $client->id;

        // product_nameからproduct_idを取得する
        $product = Product::where('product_code', $request->product_code)->first();
        $productId = $product->id;
    
        // ボタンの値によって処理を振り分け
        if ($request->input('action') === 'save_and_continue') {
            // 「続けて登録」の処理
            $clientProduct = new ClientProduct();
            $clientProduct->client_id = $clientId;
            $clientProduct->product_id = $productId;
            $clientProduct->quantity = $request->quantity;
            $clientProduct->product_version_id = $request->product_version_id;
            $clientProduct->is_customized = $request->is_customized;
            $clientProduct->is_contracted = $request->is_contracted;
            $clientProduct->install_memo = $request->install_memo;
            $clientProduct->save();

            // フォームの入力画面にリダイレクト
            return redirect()->route('client-product.create')->with('success', '登録が完了しました');
        } else {
            $clientProduct = new ClientProduct();
            $clientProduct->client_id = $clientId;
            $clientProduct->product_id = $productId;
            $clientProduct->quantity = $request->quantity;
            $clientProduct->product_version_id = $request->product_version_id;
            $clientProduct->is_customized = $request->is_customized;
            $clientProduct->is_contracted = $request->is_contracted;
            $clientProduct->install_memo = $request->install_memo;
            $clientProduct->save();

            return redirect()->route('clients.index')->with('success', '正常に登録しました');    
        }
    }

    public function show(ClientProduct $clientProduct)
    {
        //
    }

    public function edit(ClientProduct $clientProduct)
    {
        
    }

    public function update(Request $request, ClientProduct $clientProduct)
    {
        //
    }

    public function destroy(ClientProduct $clientProduct)
    {
        //
    }
}
