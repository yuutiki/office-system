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
        $perPage = config('constants.perPage');
        $typeCode = $request->input('code');
        $typeName = $request->input('name');

        $salesStageQuery = SalesStage::sortable()->with('updatedBy');

        if(!empty($typeCode)) {
            $salesStageQuery->where('sales_stage_code', $typeCode);
        }

        if(!empty($typeName)) {
            $salesStageQuery->where('sales_stage_name', $typeName);
        }

        $salesStages = $salesStageQuery->paginate($perPage);

        return view('masters.sales-stage-index', compact('salesStages'));
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
