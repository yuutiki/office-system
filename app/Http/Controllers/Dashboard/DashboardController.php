<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AccountingPeriod;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Support;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $clientCount = 0; // 仮の初期値
        $client = Client::where('trade_status_id','=','1')
                    ->get();
        $clientCount = $client->count();

        $user = Auth::user();
        $receivedAtArray = [];
        if($user){
            $mySupports = Support::whereHas('client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('received_at', 'desc')
            ->take(5)
            ->get();

            foreach($mySupports as $mySupport){
                $receivedAtArray[] = Carbon::parse($mySupport->received_at);
            }
        }

        $currentPeriod = AccountingPeriod::currentPeriod();

        if (!$currentPeriod) {
            return view('dashboard')->with('error', '現在の計上期が見つかりません。');
        }

        $totalRevenue = Project::active()
            ->whereHas('projectRevenues', function ($query) use ($currentPeriod) {
                $query->whereBetween('revenue_year_month', [$currentPeriod->period_start_at, $currentPeriod->period_end_at]);
            })
            ->join('project_revenues', 'projects.id', '=', 'project_revenues.project_id')
            ->whereBetween('project_revenues.revenue_year_month', [$currentPeriod->period_start_at, $currentPeriod->period_end_at])
            ->sum('project_revenues.revenue');

        return view('dashboard',compact('clientCount','mySupports','receivedAtArray', 'currentPeriod', 'totalRevenue'));
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
