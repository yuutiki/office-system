<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SalesStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesStageController extends Controller
{
    /**
     * 営業段階マスタの一覧表示
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 総件数を取得（AJAXで処理するため最低限の情報だけ渡す）
        $count = SalesStage::count();
        
        // 基本的なデータはフロントエンドでAJAXを使って取得するため、
        // ここではビューに必要最小限の変数のみを渡す
        return view('masters.sales-stage-index', compact('count'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SalesStage $salesStage)
    {
        //
    }

    public function edit(SalesStage $salesStage)
    {
        //
    }

    public function update(Request $request, SalesStage $salesStage)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $salesStage->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(SalesStage $salesStage)
    {
        //
    }
}
