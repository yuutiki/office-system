<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductSplitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSplitTypeController extends Controller
{
    public function index()
    {
        $productSplitTypes = ProductSplitType::with('updatedBy')->orderBy('split_type_code','asc')->paginate();
        return view('masters.product-split-type-index',compact('productSplitTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductSplitType $productSplitType)
    {
        //
    }

    public function edit(ProductSplitType $productSplitType)
    {
        //
    }

    public function update(Request $request, ProductSplitType $productSplitType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'split_type_code' => 'required|size:4',
            'split_type_name' => 'required|max:20',
        ]);

        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $productSplitType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProductSplitType $productSplitType)
    {
        //
    }
}
