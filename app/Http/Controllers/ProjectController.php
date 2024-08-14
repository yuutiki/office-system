<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Models\AccountingPeriod;
use App\Models\AccountingType;
use App\Models\Affiliation1;
use App\Models\Client;
use App\Models\Affiliation2;
use App\Models\DistributionType;
use App\Models\Affiliation3;
use App\Models\Estimate;
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
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // １ページごとの表示件数
        $perPage = config('constants.perPage');

        // 検索条件とソート条件をセッションに保存
        $searchParams = $request->all();
        $request->session()->put('search_params', $searchParams);
        $request->session()->put('sort_by', $request->input('sort', 'id'));
        $request->session()->put('sort_direction', $request->input('direction', 'asc'));

        // 検索フォームから検索条件を取得し変数に格納(後でModelの抽出クエリにわたす)
        $filters = $request->only(['project_num', 'project_name', 'client_name', 'accounting_period', 'sales_stage_ids', 'project_type_ids', 'accounting_type_ids']);

        // 同じ検索条件を別の変数にも格納(検索画面の入力欄にセットするために利用する)
        $projectNum = $filters['project_num'] ?? null;
        $projectName = $filters['project_name'] ?? null;
        $clientName = $filters['client_name'] ?? null;
        $selectedAccountingPeriod = $filters['accounting_period'] ?? null;
        $salesStageIds = $filters['$sales_stage_ids'] ?? [];

        
        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $projectsQuery = Project::filter($filters) 
            ->with('salesStage', 'accountingType', 'accountUser', 'projectRevenues',)
            ->sortable()
            ->orderBy('project_num','asc');

        // 検索結果の件数を取得
        $count = $projectsQuery->count();

        // ページネーションの適用
        $projects = $projectsQuery->paginate($perPage);


        // 全プロジェクトを取得して指定期間内の売上合計と全期間の売上合計を計算
        // $allProjects = Project::filter($filters)->with('projectRevenues')->get();
        // $totalPeriodRevenue = $allProjects->sum('totalPeriodRevenue');
        // $totalAllRevenue = $allProjects->sum('totalAllRevenue');

        // 合計金額を計算
        $totalRevenue = 0;
        if ($selectedAccountingPeriod) {
            $accountingPeriod = AccountingPeriod::find($selectedAccountingPeriod);
            if ($accountingPeriod) {
                $totalRevenue = ProjectRevenue::whereBetween('revenue_year_month', [$accountingPeriod->period_start_at, $accountingPeriod->period_end_at])
                    ->whereHas('project', function ($query) use ($filters) {
                        $query->filter($filters);
                    })
                    ->sum('revenue');
            }
        }


        // 全プロジェクトを取得して指定期間内の売上合計と全期間の売上合計を計算
        $totalPeriodRevenue = 0;
        $totalAllRevenue = 0;
        if ($selectedAccountingPeriod) {
            $accountingPeriod = AccountingPeriod::find($selectedAccountingPeriod);
            if ($accountingPeriod) {
                $totalPeriodRevenue = ProjectRevenue::whereBetween('revenue_year_month', [$accountingPeriod->period_start_at, $accountingPeriod->period_end_at])
                    ->whereHas('project', function ($query) use ($filters) {
                        $query->filter($filters);
                    })
                    ->sum('revenue');
            }
        }

        $totalAllRevenue = ProjectRevenue::whereHas('project', function ($query) use ($filters) {
            $query->filter($filters);
        })->sum('revenue');

        // 各種データの取得
        $users = User::all();
        $salesStages = SalesStage::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::orderBy('period_start_at', 'desc')->get();
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();

        return view('projects.index',compact( 'projectNum', 'projectName', 'totalRevenue', 'totalAllRevenue', 'accountingPeriods', 'filters','selectedAccountingPeriod','salesStages','distributionTypes','count','projects','users','projectTypes','accountingTypes','affiliation1s', 'affiliation2s', 'affiliation3s',));
    }

    public function create()
    {
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        $prefectures = Prefecture::all(); //都道府県

        return view('projects.create',compact('accountingPeriods','salesStages','distributionTypes','affiliation2s','affiliation1s','affiliation3s','projectTypes','accountingTypes','users','prefectures'));
    }

    public function store(ProjectStoreRequest $request)
    {
        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');

        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        $projectNumber = Project::generateProjectNumber($clientNum);


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
        $project->account_affiliation1_id = $request->account_affiliation1_id;
        $project->account_affiliation2_id = $request->account_affiliation2_id;
        $project->account_affiliation3_id = $request->account_affiliation3_id;
        $project->account_user_id = $request->account_user_id;
        $project->save();

        // 新規作成後、編集画面にリダイレクト
        return redirect()->route('projects.edit', ['project' => $project->id])->with('success', '正常に登録し編集画面に遷移しました');
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(string $id)
    {
        $project = Project::find($id);

        $companies = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();
        $users = User::all();
        $salesStages = SalesStage::all();
        $distributionTypes = DistributionType::all();
        $accountingPeriods = AccountingPeriod::all();
        $projectTypes = ProjectType::all();
        $accountingTypes = AccountingType::all();
        $prefectures = Prefecture::all(); //都道府県

        $estimates = Estimate::where('project_id', $id)->get();


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
        return view('projects.edit',compact('project','projectRevenues','accountingPeriods','salesStages','distributionTypes','affiliation2s','companies','affiliation3s','projectTypes','accountingTypes','users','revenuesWithPeriod','totalRevenue','prefectures', 'estimates'));
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        // PJ基本データを更新
        $project->project_name = $request->project_name;
        $project->sales_stage_id = $request->sales_stage_id;
        $project->project_type_id = $request->project_type_id;
        $project->accounting_type_id = $request->accounting_type_id;
        $project->distribution_type_id = $request->distribution_type_id;

        $project->billing_corporation_id = $request->billing_corporation_id;
        $project->billing_corporation_name = $request->billing_corporation_name;
        $project->billing_corporation_division_name = $request->billing_corporation_division_name;
        $project->billing_corporation_person_name = $request->billing_corporation_person_name;

        $project->billing_head_post_code = $request->head_post_code;
        $project->billing_head_prefecture = $request->prefecture_id;
        $project->billing_head_address1 = $request->head_addre1;

        $project->proposed_order_date = Carbon::parse($request->proposed_order_date . '-01');
        $project->proposed_delivery_date = Carbon::parse($request->proposed_delivery_date . '-01');
        $project->proposed_accounting_date = Carbon::parse($request->proposed_accounting_date . '-01');
        $project->proposed_payment_date = Carbon::parse($request->proposed_payment_date . '-01');
        $project->project_memo = $request->project_memo;

        $project->account_affiliation1_id = $request->account_affiliation1_id;
        $project->account_affiliation2_id = $request->account_affiliation2_id;
        $project->account_affiliation3_id = $request->account_affiliation3_id;
        $project->account_user_id = $request->account_user_id;
        $project->save();

        return redirect()->back()->with('success', '正常に更新されました');
    }

    public function destroy(Project $project, Request $request)
    {
        // 検索条件を取得
        $searchParams = $request->session()->get('search_params', []);

        $project->delete();

        return redirect()->route('projects.index', $searchParams)->with('success', '正常に削除されました');            
        // return redirect()->back()->with('success', '正常に削除されました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $projectName = $request->input('projectName');
        $projectNumber = $request->input('projectNumber');
        // $projectAffiliation2 = $request->input('affiliation2Id');

        $query = Project::query()
        ->where('project_name', 'LIKE', '%' . $projectName . '%')
        ->Where('project_num', 'LIKE', '%' . $projectNumber . '%');
        // ->Where('affiliation2_id', 'LIKE', '%' . $projectAffiliation2 . '%');
        $projects = $query->with('salesStage', 'accountUser', 'client')->get();

        return response()->json($projects);
    }













    public function showUploadForm()
    {
        return view('projects.upload-form');
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
                    // clientが見つからない場合のエラーハンドリング★重要
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

            $project->account_affiliation1_id = $row[18];
            $project->account_affiliation2_id = $row[19];
            $project->account_affiliation3_id = $row[20];
            $project->account_user_id = $row[21];
            $project->save();
        });

        $lexer->parse($csvPath, $interpreter);
    }
}
