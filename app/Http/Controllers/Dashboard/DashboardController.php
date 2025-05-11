<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AccountingPeriod;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectRevenue;
use App\Models\Support;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $clientCount = 0; // 仮の初期値
        $client = Client::where('trade_status_id','=','1')
                    ->get();
        $clientCount = $client->count();

        $user = Auth::user();
        $receivedAtArray = [];
        if($user){
            $mySupports = Support::with(['client', 'supportType', 'user'])->whereHas('client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('received_at', 'desc')
            ->take(10)
            ->get();

            foreach($mySupports as $mySupport){
                $receivedAtArray[] = Carbon::parse($mySupport->received_at);
            }
        }

        $currentPeriod = null;
        $totalRevenue = 0;

        $currentPeriod = AccountingPeriod::currentPeriod()->first();


        if ($currentPeriod) {
            $totalRevenue = Project::active()
            ->whereHas('projectRevenues', function ($query) use ($currentPeriod) {
                $query->whereBetween('revenue_year_month', [$currentPeriod->period_start_at, $currentPeriod->period_end_at]);
            })
            ->join('project_revenues', 'projects.id', '=', 'project_revenues.project_id')
            ->whereBetween('project_revenues.revenue_year_month', [$currentPeriod->period_start_at, $currentPeriod->period_end_at])
            ->sum('project_revenues.revenue') ?? 0;
        }




        // クエリパラメータにperiod_idがあればそれを優先
        if ($request->filled('period_id')) {
            $accountingPeriod = AccountingPeriod::findOrFail($request->input('period_id'));
        } else {
            // なければ、今日が属する会計期間を自動取得
            $today = Carbon::today();
            $accountingPeriod = AccountingPeriod::where('period_start_at', '<=', $today)
                ->where('period_end_at', '>=', $today)
                ->firstOrFail();
        }

        $monthlyRevenue = ProjectRevenue::getMonthlyRevenueByAccountingPeriod($accountingPeriod->id);

        // X軸ラベル作成
        $xAxisCategories = [];
        $start = Carbon::parse($accountingPeriod->period_start_at)->startOfMonth();
        $end = Carbon::parse($accountingPeriod->period_end_at)->startOfMonth();
        while ($start->lte($end)) {
            $xAxisCategories[] = $start->format('Y/n');
            $start->addMonth();
        }

        return view('dashboard',compact('clientCount','mySupports','receivedAtArray', 'currentPeriod', 'totalRevenue', 'monthlyRevenue', 'accountingPeriod', 'xAxisCategories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
