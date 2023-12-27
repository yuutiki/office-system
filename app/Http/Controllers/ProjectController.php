<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\AccountingPeriod;
use App\Models\AccountingType;
use App\Models\Client;
use App\Models\Company;
use App\Models\Department;
use App\Models\DistributionType;
use App\Models\Division;
use App\Models\Project;
use App\Models\ProjectRevenue;
use App\Models\ProjectType;
use App\Models\SalesStage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $per_page = 25;
        $projects = Project::with('salesStage','accountingType','accountUser',)->sortable()->paginate($per_page);
        $count = $projects->count();
        $user = User::all();

        // 初期化
        $totalAmountSet1 = 0;
        $totalAmountSet2 = 0;
        $projectRevenue = 0;
            // 合計金額を計算
            
        // foreach ($projects as $project) {
        //     $project->projectRevenue += $project->projectRevenues->revenue;
        //     }
        //     $project->totalAmount = $totalAmountSet1 + $totalAmountSet2;

        // }

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
        $companies = Company::all();
        $departments = Department::all();
        $divisions = Division::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        return view('project.create',compact('accountingPeriods','salesStages','distributionTypes','departments','companies','divisions','projectTypes','accountingTypes','users'));
    }

    public function store(ProjectStoreRequest $request)
    {
        ////以下にFormRequestのバリデーションを通過した場合の処理を記述////

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        $projectNumber = Project::generateProjectNumber($clientNum);

        // リクエストから 'YYYY-MM' 形式の月を取得
        // $proposedOrderMonth = $request->input('proposed_order_date');
        // $proposedDeliveryMonth = $request->input('proposed_delivery_date');
        // $proposedAccountingMonth = $request->input('proposed_accounting_date');
        // $proposedPaymentMonth = $request->input('proposed_payment_date');
        

        // PJ基本データを保存
        $project = new Project();
        $project->client_id = $clientId;
        $project->project_num = $projectNumber;// 採番したPJ番号をセット
        $project->project_name = $request->project_name;
        $project->sales_stage_id = $request->sales_stage_id;
        $project->project_type_id = $request->project_type_id;
        $project->accounting_type_id = $request->accounting_type_id;
        $project->distribution_type_id = $request->distribution_type_id;
        $project->billing_corporation_id = $request->billing_corporation_id;
        $project->proposed_order_date =  Carbon::parse($request->proposed_order_date . '-01');
        $project->proposed_delivery_date = Carbon::parse($request->proposed_delivery_date . '-01');
        $project->proposed_accounting_date =  Carbon::parse($request->proposed_accounting_date . '-01');
        $project->proposed_payment_date =  Carbon::parse($request->proposed_payment_date . '-01');
        $project->project_memo = $request->project_memo;
        $project->account_company_id = $request->account_company_id;
        $project->account_department_id = $request->account_department_id;
        $project->account_division_id = $request->account_division_id;
        $project->account_user_id = $request->account_user_id;
        $project->save();

// project.editに後で変更する
        return redirect()->route('project.index')->with('success', '正常に登録しました');
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(string $id)
    {
        $project = Project::find($id);

        $companies = Company::all();
        $departments = Department::all();
        $divisions = Division::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();



        $projectRevenues = ProjectRevenue::where('project_id',$id)->orderBy('revenue_year_month','asc')->get();

        $totalRevenue = 0;

        // 会計期データを取得
        $accountingPeriods = AccountingPeriod::all();

        // 売上データごとに会計期を判定して表示
        $revenuesWithPeriod = [];
        foreach ($projectRevenues as $revenue) {
            $targetDate = Carbon::parse($revenue->revenue_year_month);
    
            $belongingPeriod = null;
    
            foreach ($accountingPeriods as $period) {
                $start = Carbon::parse($period->period_start_at);
                $end = Carbon::parse($period->period_end_at);
    
                if ($targetDate->between($start, $end)) {
                    $belongingPeriod = $period->period_name;
                    break;
                }
            }

            $totalRevenue += $revenue->revenue; // 合計金額を加算
    
            $revenuesWithPeriod[] = [
                'revenue' => $revenue,
                'belongingPeriod' => $belongingPeriod,
                'formatRevenueDate' => $targetDate->format('Y-m'),
            ];
        }
        return view('project.edit',compact('project','projectRevenues','accountingPeriods','salesStages','distributionTypes','departments','companies','divisions','projectTypes','accountingTypes','users','revenuesWithPeriod','totalRevenue'));
        
    }

    public function update(Request $request, Project $project)
    {
            //// FormRequestのバリデーションを通過した場合の処理を記述 ////

    // フォームからの値を変数に格納
    $clientNum = $request->input('client_num');

    // client_numからclient_idを取得する
    $client = Client::where('client_num', $clientNum)->first();
    $clientId = $client->id;

    // リクエストから 'YYYY-MM' 形式の月を取得
    // $proposedOrderMonth = $request->input('proposed_order_date');
    // $proposedDeliveryMonth = $request->input('proposed_delivery_date');
    // $proposedAccountingMonth = $request->input('proposed_accounting_date');
    // $proposedPaymentMonth = $request->input('proposed_payment_date');

    // PJ基本データを更新
    $project->client_id = $clientId;
    $project->project_name = $request->project_name;
    $project->sales_stage_id = $request->sales_stage_id;
    $project->project_type_id = $request->project_type_id;
    $project->accounting_type_id = $request->accounting_type_id;
    $project->distribution_type_id = $request->distribution_type_id;
    $project->billing_corporation_id = $request->billing_corporation_id;
    $project->proposed_order_date = Carbon::parse($request->proposed_order_date . '-01');
    $project->proposed_delivery_date = Carbon::parse($request->proposed_delivery_date . '-01');
    $project->proposed_accounting_date = Carbon::parse($request->proposed_accounting_date . '-01');
    $project->proposed_payment_date = Carbon::parse($request->proposed_payment_date . '-01');
    $project->project_memo = $request->project_memo;
    $project->account_company_id = $request->account_company_id;
    $project->account_department_id = $request->account_department_id;
    $project->account_division_id = $request->account_division_id;
    $project->account_user_id = $request->account_user_id;
    $project->save();

    // project.editに後で変更する
    return redirect()->route('project.index')->with('success', '正常に更新しました');

    }

    public function destroy(Project $project)
    {
        //
    }
}
