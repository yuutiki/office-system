<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\AccountingPeriod;
use App\Models\AccountingType;
use App\Models\Client;
use App\Models\Company;
use App\Models\Department;
use App\Models\DistributionType;
use App\Models\Affiliation3;
use App\Models\Prefecture;
use App\Models\Project;
use App\Models\ProjectRevenue;
use App\Models\ProjectType;
use App\Models\SalesStage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class ProjectController extends Controller
{
    public function index()
    {
        $per_page = 25;
        $projects = Project::with('salesStage','accountingType','accountUser','projectRevenues',)->sortable()->orderBy('project_num','asc')->paginate($per_page);
        $count = $projects->count();
        $users = User::all();

        // 初期化
        $totalAmount = 0;

        foreach ($projects as $project) {
            $project->totalAmount = 0;
    
            foreach ($project->projectRevenues as $revenue) {
                // 各収益を加算
                $project->totalAmount += $revenue->revenue;
            }
    
            // 合計金額を全体の合計に加算
            $totalAmount += $project->totalAmount;
        }

        $salesStages = SalesStage::all();
        $projectTypes = ProjectType::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        return view('project.index',compact('accountingPeriods','salesStages','distributionTypes','count','projects','totalAmount','users','projectTypes'));
    }

    public function create()
    {
        $companies = Company::all();
        $departments = Department::all();
        $affiliation3s = Affiliation3::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        $prefectures = Prefecture::all(); //都道府県

        return view('project.create',compact('accountingPeriods','salesStages','distributionTypes','departments','companies','affiliation3s','projectTypes','accountingTypes','users','prefectures'));
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
        $project->account_affiliation3_id = $request->account_affiliation3_id;
        $project->account_user_id = $request->account_user_id;
        $project->save();

        // 新規作成後、編集画面にリダイレクト
        return redirect()->route('project.edit', ['project' => $project->id])->with('success', '正常に登録し編集画面に遷移しました');
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
        $affiliation3s = Affiliation3::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        $prefectures = Prefecture::all(); //都道府県



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
        return view('project.edit',compact('project','projectRevenues','accountingPeriods','salesStages','distributionTypes','departments','companies','affiliation3s','projectTypes','accountingTypes','users','revenuesWithPeriod','totalRevenue','prefectures'));
        
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
    $project->account_affiliation3_id = $request->account_affiliation3_id;
    $project->account_user_id = $request->account_user_id;
    $project->save();

    // project.editに後で変更する
    return redirect()->back()->with('success', '正常に更新されました');

    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->back()->with('success', '正常に削除されました');
    }



    public function upload(Request $request)
    {
        // ファイルがアップロードされているかチェック
        if (!$request->hasFile('csv_upload')) {
        // エラーメッセージをセットしてリダイレクト
        return redirect()->back()->with('error', 'アップロードするCSVファイルが選択されていません。');
        }

        $csvFile = $request->file('csv_upload');
        
        // CSVファイルの一時保存先パス
        $csvPath = $csvFile->getRealPath();
        
        // CSVデータのパースとデータベースへの登録処理
        $this->parseCSVAndSaveToDatabase($csvPath);

        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', 'CSVファイルをアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath)
    {
        // CSVファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win', true);
        
        $config = new LexerConfig();
        $config->setFromCharset($fromCharset);

        $config->setIgnoreHeaderLine(true); // ヘッダを無視する設定
        $lexer = new Lexer($config);
        $interpreter = new Interpreter();

         // CSV行をパースした際に実行する処理を定義
        $interpreter->addObserver(function (array $row) {
            $project = new Project();

            $clientNum = $row[0];
                $client = Client::where('client_num', $clientNum)->first();
                if ($client) {
                    $project->client_id = $client->id;
                } else {
                    // clientが見つからない場合のエラーハンドリング
                }

            $projectNumber = Project::generateProjectNumber($clientNum);
            $project->project_num = $projectNumber;

            $project->project_name = $row[1];
            $project->sales_stage_id = $row[2];

            $project->project_type_id = $row[3];
            $project->accounting_type_id = $row[4];
            $project->distribution_type_id = $row[5];
            $project->billing_corporation_id = $row[6];
            
            $project->proposed_order_date = Carbon::parse($row[7] . '-01');
            $project->proposed_delivery_date = Carbon::parse($row[8] . '-01');
            $project->proposed_accounting_date = Carbon::parse($row[9] . '-01');
            $project->proposed_payment_date = Carbon::parse($row[10] . '-01');

            $project->billing_corporation_name = $row[11];
            $project->billing_corporation_division_name = $row[12];
            $project->billing_corporation_person_name = $row[13];
            $project->billing_head_post_code = $row[14];
            $project->billing_head_prefecture = $row[15];
            $project->billing_head_address1 = $row[16];

            $project->project_memo = $row[17];

            $project->account_company_id = $row[18];
            $project->account_department_id = $row[19];
            $project->account_affiliation3_id = $row[20];
            $project->account_user_id = $row[21];
            $project->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }
}
