<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVersionController extends Controller
{
    public function index()
    {
        $productVersions = ProductVersion::with('updatedBy')->orderBy('version_code','asc')->paginate(100);
        return view('masters.product-version-index',compact('productVersions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductVersion $productVersion)
    {
        //
    }

    public function edit(ProductVersion $productVersion)
    {
        //
    }

    public function update(Request $request, ProductVersion $productVersion)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $productVersion->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(ProductVersion $productVersion)
    {
        //
    }
}
