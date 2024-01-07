<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductMaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductMakerController extends Controller
{
    public function index()
    {
        $productMakers = ProductMaker::with('updatedBy')->orderBy('maker_code', 'asc')->paginate(50);
        return view('masters.product-maker-index',compact('productMakers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductMaker $productMaker)
    {
        //
    }

    public function edit(ProductMaker $productMaker)
    {
        //
    }

    public function update(Request $request, ProductMaker $productMaker)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->validate([
            'maker_code' => 'required|size:2',
            'maker_name' => 'required|max:20',
        ]);
        
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $productMaker->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProductMaker $productMaker)
    {
        //
    }
}
