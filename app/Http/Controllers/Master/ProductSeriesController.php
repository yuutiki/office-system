<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSeriesController extends Controller
{
    public function index()
    {
        $productSeries = ProductSeries::with('updatedBy')->orderBy('series_code','asc')->paginate();
        return view('masters.product-series-index',compact('productSeries'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductSeries $productSeries)
    {
        //
    }

    public function edit(ProductSeries $productSeries)
    {
        //
    }

    public function update(Request $request, ProductSeries $productSeries)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $productSeries->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProductSeries $productSeries)
    {
        //
    }
}
