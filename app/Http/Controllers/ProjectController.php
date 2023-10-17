<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use App\Models\DistributionType;
use App\Models\Project;
use App\Models\SalesStage;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        return view('project.create',compact('accountingPeriods','salesStages','distributionTypes'));
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
