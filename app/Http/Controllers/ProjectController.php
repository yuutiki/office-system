<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use App\Models\Department;
use App\Models\DistributionType;
use App\Models\Project;
use App\Models\SalesStage;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $per_page = 25;
        $projects = Project::with('salesStage','accountingType',)->sortable()->paginate($per_page);
        $count = $projects->count();
        $user = User::all();


        // 初期化
        $totalAmountSet1 = 0;
        $totalAmountSet2 = 0;
            // 合計金額を計算

        foreach ($projects as $project) {
            $project->totalAmountSet1 = 0;
            $project->totalAmountSet2 = 0;
            for ($month = 0; $month < 12; $month++) {
                $project->totalAmountSet1 += $project->{"revenue_distribution_set1_" . $month};
                $project->totalAmountSet2 += $project->{"revenue_distribution_set2_" . $month};
            }
            $project->totalAmount = $totalAmountSet1 + $totalAmountSet2;

            // 合計金額を累積計算
            $totalAmountSet1 += $project->totalAmountSet1;
            $totalAmountSet2 += $project->totalAmountSet2;
        }

        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        return view('project.index',compact('accountingPeriods','salesStages','distributionTypes','count','projects','totalAmountSet1','totalAmountSet2'));
    }

    public function create()
    {
        $departments = Department::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        return view('project.create',compact('accountingPeriods','salesStages','distributionTypes','departments'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        //
    }
}
