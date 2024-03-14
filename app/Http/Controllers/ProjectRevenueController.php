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
        $numericValue = filter_var($request->revenue_amount, FILTER_SANITIZE_NUMBER_INT);
        $projectRevenue->revenue = $numericValue;

        // モデルを保存
        if (is_numeric($numericValue)) {
            $projectRevenue->save();
            return redirect()->route('projects.edit',$request->modalproject_id)->with('success', '正常に登録しました');
        }else {
            return redirect()->back()->with('error', 'Invalid numeric input');
        }

    }

    public function show(ProjectRevenue $projectRevenue)
    {
        //
    }

    public function edit(ProjectRevenue $projectRevenue)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // リクエストデータを使って既存のLinkモデルを取得
        $projectRevenue = ProjectRevenue::findOrFail($id);
        
        // プロジェクトID、収益の年月、収益の金額を更新
        $projectRevenue->project_id = $request->modalproject_id;
        $projectRevenue->revenue_year_month = Carbon::parse($request->revenue_date . '-01');
        $numericValue = filter_var($request->revenue_amount, FILTER_SANITIZE_NUMBER_INT);
        $projectRevenue->revenue = $numericValue;

        // モデルを保存
        if (is_numeric($numericValue)) {
            $projectRevenue->save();
            return redirect()->route('projects.edit', $request->modalproject_id)->with('success', '正常に更新しました');
        } else {
            return redirect()->back()->with('error', 'Invalid numeric input');
        }

    }

    public function destroy(string $id)
    {
        $projectRevenue = ProjectRevenue::find($id);
        $projectId = $projectRevenue->project->id;

        $projectRevenue->delete();

        return redirect()->route('projects.edit', $projectId)->with('message', '削除しました');
    }

    public function bulkInsert(Request $request)
    {
        $projectId = $request->input('Insert_modalproject_id');
        $numericTotalValue = filter_var($request->total_amount, FILTER_SANITIZE_NUMBER_INT);
        $totalAmount = $numericTotalValue;
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
        return redirect()->route('projects.edit',$request->Insert_modalproject_id)->with('success', '正常に登録しました');
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        // $selectedIds には削除対象のレコードのIDが配列として格納されています

        if (!empty($selectedIds)) {
            // Eloquent モデルの delete メソッドを使用して一括削除
            ProjectRevenue::whereIn('id', $selectedIds)->delete();

            return redirect()->back()->with('success', '選択されたレコードを一括削除しました');
        } else {
            return redirect()->back()->with('error', '削除するレコードが選択されていません');
        }
    }
}