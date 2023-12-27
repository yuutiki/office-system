<?php

namespace App\Http\Controllers;

use App\Models\ProjectRevenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function destroy(string $id)
    {
        $projectRevenue = ProjectRevenue::find($id);
        $projectId = $projectRevenue->project->id;

        $projectRevenue->delete();

        return redirect()->route('project.edit', $projectId)->with('message', '削除しました');
    }

    public function bulkInsert(Request $request)
    {
        $projectId = $request->input('Insert_modalproject_id');
        $totalAmount = $request->input('total_amount');
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $months = $endDate->diffInMonths($startDate);

        // 月ごとの金額
        $monthlyAmount = round($totalAmount / ($months + 1));
        $totalAmountWithoutFraction = $monthlyAmount * ($months + 1);

        // 切り捨てを適用して端数を計算
        $fraction = $totalAmount - $totalAmountWithoutFraction;

        $projectRevenuesData = [];

        for ($i = 0; $i <= $months; $i++) {
            // 最初の月に端数を加算
            $amount = $monthlyAmount + ($i === 0 ? $fraction : 0);

            $projectRevenuesData[] = [
                'project_id' => $projectId,
                'revenue_year_month' => $startDate->copy()->addMonths($i),
                'revenue' => $amount,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }



        // Model内で定義した bulkInsert メソッドを呼び出し
        ProjectRevenue::bulkInsert($projectRevenuesData);

        // 成功したらリダイレクトやレスポンスを返す
        return redirect()->route('project.edit',$request->Insert_modalproject_id)->with('success', '正常に登録しました');

    }
}