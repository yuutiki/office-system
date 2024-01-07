<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::with('updatedBy')->orderBy('type_code','asc')->paginate();
        return view('masters.product-type-index',compact('productTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductType $productType)
    {
        //
    }

    public function edit(ProductType $productType)
    {
        //
    }

    public function update(Request $request, ProductType $productType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $productType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProductType $productType)
    {
        //
    }
}
