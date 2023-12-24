<?php

namespace App\Http\Controllers;

use App\Models\ProjectRevenue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectRevenueController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // リクエストデータを使って新しいLinkモデルのインスタンスを作成
        $projectRevenue = new ProjectRevenue;
        $projectRevenue->project_id = $request->modalproject_id;
        $projectRevenue->revenue_year_month = Carbon::parse($request->revenue_date . '-01');
        $projectRevenue->revenue = $request->revenue_amount;

        // モデルを保存
        $projectRevenue->save();

        return redirect()->route('project.edit',$request->modalproject_id)->with('success', '正常に登録しました');
    }

    public function show(ProjectRevenue $projectRevenue)
    {
        //
    }

    public function edit(ProjectRevenue $projectRevenue)
    {
        //
    }

    public function update(Request $request, ProjectRevenue $projectRevenue)
    {
        //
    }

    public function destroy(ProjectRevenue $projectRevenue)
    {
        //
    }
}
