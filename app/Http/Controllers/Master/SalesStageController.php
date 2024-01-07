<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SalesStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesStageController extends Controller
{
    public function index()
    {
        $salesStages = SalesStage::with('updatedBy')->orderBy('sales_stage_code','asc')->paginate();
        return view('masters.sales-stage-index',compact('salesStages'));
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
