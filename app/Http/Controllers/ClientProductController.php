<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientProduct\StoreClientProductRequest;
use App\Models\Affiliation2;
use App\Models\ClientProduct;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductSeries;
use App\Models\ProductSplitType;
use App\Models\ProductType;
use App\Models\ProductVersion;
use App\Models\TradeStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');

        // 検索条件を取得してセッションに保存
        $searchParams = $request->session()->put('search_params', $request->all());
        // リクエストから並び替えの条件を取得しSessionに保存
        $request->session()->put([
            'sort_by' => $request->input('sort', 'id'),
            'sort_direction' => $request->input('direction', 'asc'),
        ]);


        // 一括変更用のデータを追加
        $productVersions = ProductVersion::orderBy('version_name')->get();
        $productSeries = ProductSeries::orderBy('series_name')->get();

        $tradeStatuses = TradeStatus::all();
        $selectedTradeStatuses = $request->trade_statuses ?? [];

        // // ここより下は要精査
        // $allColumns = Corporation::getAvailableColumns();

        // // ユーザーの設定を取得
        // $userSettings = UserColumnSetting::where('user_id', auth()->id())
        // ->where('page_identifier', 'corporations_index')
        // ->first();

        // $visibleColumns = $userSettings ? $userSettings->visible_columns : array_keys($allColumns);





        // 検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['corporation_num', 'corporation_name', 'invoice_num', 'trade_status_ids','tax_status_ids']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $invoiceNum = $filters['invoice_num'] ?? null;
        $tradeStatusIds = $filters['trade_status_ids'] ?? [];
        $taxStatusIds = $filters['tax_status_ids'] ?? [];


        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $clientProducts = ClientProduct::with('client', 'product', 'productVersion', 'productSeries')->sortable()->paginate($perPage);

        // $corporations = Corporation::filter($filters)
        //     ->with('prefecture', 'credits')
        //     ->withCount('clients')
        //     ->addSelect(['latest_credit_limit' => CorporationCredit::select('credit_limit')
        //         ->whereColumn('corporation_id', 'corporations.id')
        //         ->latest()
        //         ->limit(1)
        //     ])
        //     ->sortable()
        //     ->paginate($perPage);

        // // 検索結果の全 corporation_id を取得しセッションに保存
        // $corporationIds = $corporations->pluck('id')->toArray();
        // session()->put('corporation_ids', $corporationIds);
            
        // 検索結果の件数を取得
        $count = $clientProducts->total();

        return view('client-product.index', compact('searchParams', 'tradeStatuses', 'selectedTradeStatuses', 'clientProducts', 'count' ,'filters', 'productSeries', 'productVersions', 'invoiceNum', 'tradeStatusIds', 'taxStatusIds',));
    }

    public function create()
    {
        $users = User::all();
        $affiliation2s = Affiliation2::all(); //管轄事業部
        $productSeries = ProductSeries::all();
        $productVersions = ProductVersion::orderby('version_code','desc')->get();
        $productTypes = ProductType::all();
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

        return view('client-product.create',compact('affiliation2s', 'users', 'productSeries', 'productVersions', 'productTypes', 'productSplitTypes', 'clientNum', 'clientName', 'clientId', 'client'));
    }

    public function store(StoreClientProductRequest $request)
    {
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $request->client_num)->first();

        $clientProduct = new ClientProduct();
        $clientProduct->client_id = $client->id;
        $clientProduct->product_id = $request->product_id;
        $clientProduct->quantity = $request->quantity;
        $clientProduct->product_series_id = $request->product_series_id;
        $clientProduct->product_version_id = $request->product_version_id;
        $clientProduct->is_customized = $request->is_customized;
        $clientProduct->is_contracted = $request->is_contracted;
        $clientProduct->install_memo = $request->install_memo;
        $clientProduct->save();

    
        // ボタンの値によって処理を振り分け
        if ($request->input('action') === 'save_and_continue') {
            // 「続けて登録」の処理
            return redirect()->route('client-products.create')->with('success', '登録が完了し、続けて登録します');
        } else {
            return redirect()->route('client-products.index')->with('success', '正常に登録しました');    
        }
    }

    public function show(ClientProduct $clientProduct)
    {
        //
    }

    public function edit(ClientProduct $clientProduct)
    {
        $users = User::all();
        $affiliation2s = Affiliation2::all(); //管轄事業部?????
        $productSeries = ProductSeries::all();
        $productVersions = ProductVersion::orderby('version_code','desc')->get();
        $productTypes = ProductType::all();
        $productSplitTypes = ProductSplitType::leftJoin('products', 'product_split_types.id', '=', 'products.product_split_type_id')
        ->where('products.is_listed', 1)
        ->whereNotNull('products.product_split_type_id') // 製品種別が存在する場合のみ取得
        ->select('product_split_types.*')
        ->distinct()
        ->get();

        return view('client-product.edit',compact('affiliation2s', 'users', 'productSeries', 'productVersions', 'productTypes', 'productSplitTypes', 'clientProduct'));
    }

    public function update(StoreClientProductRequest $request, ClientProduct $clientProduct)
    {
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $request->client_num)->first();
        $clientProduct = ClientProduct::find($clientProduct->id);

        $clientProduct->client_id = $client->id;
        $clientProduct->product_id = $request->product_id;
        $clientProduct->quantity = $request->quantity;
        $clientProduct->product_series_id = $request->product_series_id;
        $clientProduct->product_version_id = $request->product_version_id;
        $clientProduct->is_customized = $request->is_customized;
        $clientProduct->is_contracted = $request->is_contracted;
        $clientProduct->install_memo = $request->install_memo;
        $clientProduct->save();

        return redirect()->back()->with('success', '正常に更新しました');    
    }

    public function destroy(ClientProduct $clientProduct)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds', []);
    
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '削除するレコードが選択されていません');
        }
    
        if (!empty($selectedIds)) {
            ClientProduct::whereIn('id', $selectedIds)->delete();
        }
    
        return redirect()->back()->with('success', '選択された導入製品情報を削除しました');
    }

    /**
     * 一括変更処理
     */
    public function bulkUpdate(Request $request)
    {
        // バリデーション
        $request->validate([
            'selected_ids' => 'required|string',
            'update_fields' => 'required|array|min:1',
            'update_fields.*' => 'in:product_version_id,product_series_id,is_customized,is_contracted',
            'product_version_id' => 'nullable|exists:product_versions,id',
            'product_series_id' => 'nullable|exists:product_series,id',
            'is_customized' => 'nullable|boolean',
            'is_contracted' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            // 選択されたIDを配列に変換
            $selectedIds = explode(',', $request->selected_ids);
            
            // 更新データを準備
            $updateData = [];
            $updateFields = $request->update_fields;

            foreach ($updateFields as $field) {
                switch ($field) {
                    case 'product_version_id':
                        if ($request->filled('product_version_id')) {
                            $updateData['product_version_id'] = $request->product_version_id;
                        }
                        break;
                    case 'product_series_id':
                        if ($request->filled('product_series_id')) {
                            $updateData['product_series_id'] = $request->product_series_id;
                        }
                        break;
                    case 'is_customized':
                        if ($request->has('is_customized') && $request->is_customized !== '') {
                            $updateData['is_customized'] = $request->boolean('is_customized');
                        }
                        break;
                    case 'is_contracted':
                        if ($request->has('is_contracted') && $request->is_contracted !== '') {
                            $updateData['is_contracted'] = $request->boolean('is_contracted');
                        }
                        break;
                }
            }

            if (empty($updateData)) {
                throw new \Exception('更新するデータがありません');
            }

            // 一括更新実行
            $updatedCount = ClientProduct::whereIn('id', $selectedIds)->update($updateData);

            DB::commit();

            return redirect()->route('client-products.index')
                            ->with('success', "{$updatedCount}件のデータを一括変更しました");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('client-products.index')
                            ->with('error', '一括変更中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
