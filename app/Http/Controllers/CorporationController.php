<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorporationStoreRequest;
use App\Http\Requests\CorporationUpdateRequest;
use App\Http\Requests\CorporationUploadRequest;
use App\Models\Corporation;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Goodby\CSV\Import\Standard\InterpreterConfig;
use Illuminate\Support\Facades\Response;
use App\Jobs\ExportCorporationsCsv;
use App\Models\CorporationCredit;
use App\Models\CorporationSearchModalDisplayItem;
use App\Models\Prefecture;
use App\Models\UserColumnSetting;
use App\Services\InvoiceApiService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class CorporationController extends Controller
{
    /**
     * ページネーション設定
     */
    private const ALLOWED_PER_PAGE = [100, 300, 500];
    private const DEFAULT_PER_PAGE = 100;

    /**
     * 表示件数の取得とバリデーション
     */
    private function getValidatedPerPage(Request $request): int
    {
        $perPage = (int) $request->get('per_page', self::DEFAULT_PER_PAGE);
        
        // バリデーション
        if (!in_array($perPage, self::ALLOWED_PER_PAGE)) {
            $perPage = self::DEFAULT_PER_PAGE;
        }
        
        return $perPage;
    }

    protected $invoiceService;

    public function __construct(InvoiceApiService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(Request $request)//検索用にrequestを受取る
    {
        $allColumns = Corporation::getAvailableColumns();

        // ユーザーの設定を取得
        $userSettings = UserColumnSetting::where('user_id', auth()->id())
        ->where('page_identifier', 'corporations_index')
        ->first();

        $visibleColumns = $userSettings ? $userSettings->visible_columns : array_keys($allColumns);

        // $permissions = [
        //     'can_create' => Gate::allows('storeUpdate_corporations'),
        //     'can_edit' => Gate::allows('storeUpdate_corporations'),
        //     'can_delete' => Gate::allows('delete_corporations'),
        //     'can_download' => Gate::allows('download_corporations'),
        //     'can_admin' => Gate::allows('admin_corporations'),
        // ];
        // １ページごとの表示件数
        // $perPage = config('constants.perPage');
        // 1. 表示件数の取得とバリデーション
        $perPage = $this->getValidatedPerPage($request);

        // 検索条件を取得してセッションに保存
        $searchParams = $request->session()->put('search_params', $request->all());

        // リクエストから並び替えの条件を取得しSessionに保存
        $request->session()->put([
            'sort_by' => $request->input('sort', 'id'),
            'sort_direction' => $request->input('direction', 'asc'),
        ]);

        // 検索フォームから検索条件を取得し変数に格納
        $filters = $request->only(['corporation_num', 'corporation_name', 'invoice_num', 'trade_status_ids','tax_status_ids']);

        // 同じ条件を別の変数にも格納(画面の検索条件入力欄にセットするために利用する)
        $CorporationNum = $filters['corporation_num'] ?? null;
        $CorporationName = $filters['corporation_name'] ?? null;
        $invoiceNum = $filters['invoice_num'] ?? null;
        $tradeStatusIds = $filters['trade_status_ids'] ?? [];
        $taxStatusIds = $filters['tax_status_ids'] ?? [];


        //上記で$filters変数に格納した検索条件をModelに渡し、検索処理を行う。結果を$corporationsに詰める
        $corporations = Corporation::filter($filters)
            ->with('prefecture', 'credits')
            ->withCount('clients')
            ->addSelect(['latest_credit_limit' => CorporationCredit::select('credit_limit')
                ->whereColumn('corporation_id', 'corporations.id')
                ->latest()
                ->limit(1)
            ])
            ->sortable()
            ->paginate($perPage);

        // 検索結果の全 corporation_id を取得しセッションに保存
        $corporationIds = $corporations->pluck('id')->toArray();
        session()->put('corporation_ids', $corporationIds);

        // 検索結果の全件データも取得してセッションに保存（ドロワー用）
        $allSearchResults = Corporation::filter($filters)
            ->with('prefecture', 'credits')
            ->addSelect(['latest_credit_limit' => CorporationCredit::select('credit_limit')
                ->whereColumn('corporation_id', 'corporations.id')
                ->latest()
                ->limit(1)
            ])
            ->orderBy(session('sort_by', 'id'), session('sort_direction', 'asc'))
            ->get();
        
        session()->put('search_results', $allSearchResults);
            
        // 検索結果の件数を取得
        $count = $corporations->total();

        return view('corporations.index', compact('searchParams', 'allColumns', 'visibleColumns', 'corporations', 'count' ,'filters', 'CorporationNum', 'CorporationName', 'invoiceNum', 'tradeStatusIds', 'taxStatusIds',));
    }

    public function create(Request $request)
    {
        $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得
        $prefectures = Prefecture::all();
        return view('corporations.create',compact('prefectures', 'activeTab', ));
    }

    public function store(CorporationStoreRequest $request)
    {
        // リクエストデータをコピー
        $data = $request->validated();

        // インボイス番号が入力されている場合のみAPIリクエストを実行
        if ($invoiceNum = $data['invoice_num'] ?? null) {
            try {
                $apiResponse = $this->invoiceService->getInvoiceInfo($invoiceNum);

                // APIレスポンスを確認し、存在すればtrueを格納
                $exists = !empty($apiResponse['announcement']);

                // is_active_invoice フラグを$dataに追加
                $data['is_active_invoice'] = $exists;
                if ($exists && isset($apiResponse['announcement'][0]['registrationDate'])) {
                    // registrationDate を取得し、invoice_at に設定
                    $registrationDate = $apiResponse['announcement'][0]['registrationDate'];
                    $data['invoice_at'] = $registrationDate;
                } else {
                    // registrationDate が存在しない場合は null を設定
                    $data['invoice_at'] = null;
                }
            } catch (\Exception $e) {
                // APIリクエストに失敗した場合のログ記録（開発者向け）
                \Log::error('APIリクエストに失敗しました: ' . $e->getMessage());
                
                // ユーザーには一般的なメッセージを表示
                return back()->withInput()->with('warning', 'インボイス情報の確認ができませんでした。後ほど再度お試しください。');
            }
        } else {
            // インボイス番号が入力されていない場合
            $data['is_active_invoice'] = false;
            $data['invoice_at'] = null;
        }

        // リクエスト全体から与信情報以外を抽出
        $data = $request->except([
            'credit_limit',
            'credit_rate',
            'credit_rater',
            'credit_reason',
            '_token',
        ]);

        try {
            $corporation = DB::transaction(function () use ($data, $request) {
                // storeWithTransaction メソッドを使用して法人情報を登録
                $corporation = Corporation::storeWithTransaction($data);
    
                // 与信情報の登録
                if (!empty($request->input('credit_limit'))) {
                    $corporation->credits()->create([
                        'credit_limit' => $request->input('credit_limit'),
                        'credit_rate' => $request->input('credit_rate'),
                        'credit_rater' => $request->input('credit_rater'),
                        'credit_reason' => $request->input('credit_reason'),
                        // 他の与信情報のカラムを追加
                    ]);
                }
    
                return $corporation;
            });
    
            // 編集画面へのURLを生成
            $editUrl = route('corporations.edit', ['corporation' => $corporation->id]);
    
            // 生成されたURLにリダイレクト
            return redirect($editUrl)->with('success', '正常に登録しました');
        } catch (\Exception $e) {
            \Log::error('法人情報の登録に失敗しました: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '登録に失敗しました。');
        }
    }

    public function show(Corporation $Corporation)
    {
        //
    }

    public function edit(string $id, Request $request)
    {
    $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得
    $prefectures = Prefecture::all();

    $corporation = Corporation::findOrFail($id);
    $credits = CorporationCredit::where('corporation_id',$id)->orderBy('created_at','desc')->get();

    // 最新の与信情報を取得
    $latestCredit = $corporation->credits()->orderBy('created_at', 'desc')->first();

    // セッションから検索結果データを取得
    $searchResults = session('search_results', collect());
    $searchParams = session('search_params', []);
    $corporationIds = session('corporation_ids', []);

    // 現在のIDの位置を検索
    $currentIndex = array_search((int)$id, $corporationIds);
    $totalCount = count($corporationIds);

    // 前後のIDを取得
    $prevId = $currentIndex !== false && $currentIndex > 0 ? $corporationIds[$currentIndex - 1] : null;
    $nextId = $currentIndex !== false && $currentIndex < count($corporationIds) - 1 ? $corporationIds[$currentIndex + 1] : null;

    // 都道府県データを取得（検索条件表示用）
    $prefectureNames = Prefecture::pluck('prefecture_name', 'id');

    return view('corporations.edit', compact(
        'corporation', 
        'prefectures', 
        'activeTab', 
        'credits', 
        'latestCredit', 
        'prevId', 
        'nextId',
        'searchResults',
        'searchParams',
        'currentIndex',
        'totalCount',
        'prefectureNames'
    ));
    }

    public function update(CorporationUpdateRequest $request, string $id)
    {
        // リクエストデータをコピー
        $data = $request->validated();

        try {
            // モデルを見つけて、存在するか確認
            $corporation = Corporation::findOrFail($id);

            // インボイス番号が入力されている場合のみAPIリクエストを実行
            if ($invoiceNum = $data['invoice_num'] ?? null) {
                try {
                    $apiResponse = $this->invoiceService->getInvoiceInfo($invoiceNum);

                    // APIレスポンスを確認し、存在すればtrueを格納
                    $exists = !empty($apiResponse['announcement']);

                    // is_active_invoice フラグを$dataに追加
                    $data['is_active_invoice'] = $exists;
                    if ($exists && isset($apiResponse['announcement'][0]['registrationDate'])) {
                        // registrationDate を取得し、invoice_at に設定
                        $registrationDate = $apiResponse['announcement'][0]['registrationDate'];
                        $data['invoice_at'] = $registrationDate;
                    } else {
                        // registrationDate が存在しない場合は null を設定
                        $data['invoice_at'] = null;
                    }
                } catch (\Exception $e) {
                    // APIリクエストに失敗した場合のログ記録（開発者向け）
                    \Log::error('APIリクエストに失敗しました: ' . $e->getMessage());
                    
                    // ユーザーには一般的なメッセージを表示
                    return back()->withInput()->with('warning', '無効なインボイス番号でした');
                }
            } else {
                // インボイス番号が入力されていない場合
                $data['is_active_invoice'] = false;
                $data['invoice_at'] = null;
            }

            // データを更新
            $corporation->fill($data)->save();
            // return redirect()->route('corporations.edit', $id)->with('success', '正常に更新されました');



            return redirect()->back()->with('success', '正常に更新されました');
            
        } catch (ModelNotFoundException $e) {
            // モデルが見つからない場合のエラーメッセージ
            return redirect()->back()->with('error', '指定されたデータが見つかりませんでした');
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            // 検索条件を取得
            $searchParams = $request->session()->get('search_params', []);
        
            // 子データが存在するか確認
            $Corporation = Corporation::with('clients')->findOrFail($id);

            // 子データが存在する場合は削除を中止
            if ($Corporation->clients()->exists()) {
                return redirect()->back()->with('error', '顧客データが存在するため、削除できません');
            }

            // 子データが存在しない場合は削除を実行
            $Corporation->delete();
            return redirect()->route('corporations.index', $searchParams)->with('success', '正常に削除されました');            

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', '対象のデータが見つかりませんでした');
        }
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds', []);
    
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '削除するレコードが選択されていません');
        }
    
        // 削除できない企業のIDを取得（顧客データが存在する企業）
        $corporationsWithClients = Corporation::whereIn('id', $selectedIds)
            ->whereHas('clients')
            ->pluck('id')
            ->toArray();
    
        // 削除可能な企業のIDを取得（顧客データがない企業）
        $corporationsToDelete = array_diff($selectedIds, $corporationsWithClients);
    
        if (!empty($corporationsToDelete)) {
            Corporation::whereIn('id', $corporationsToDelete)->delete();
        }
    
        // メッセージを設定
        if (!empty($corporationsWithClients)) {
            return redirect()->back()->with('error', '一部の法人は顧客/業者データが存在するため、削除できませんでした');
        }
    
        return redirect()->back()->with('success', '選択された法人を削除しました');
    }
    

    //モーダル用の非同期検索メソッド
    public function search(Request $request)
    {
        $query = Corporation::query();

        if (!empty($request->corporation_name)) {
            $query->where('corporation_name', 'LIKE', '%' . $request->corporation_name . '%');
        }

        if (!empty($request->corporation_num)) {
            $query->where('corporation_num', 'LIKE', '%' . $request->corporation_num . '%');
        }

        $corporations = $query->get();

        // 画面IDに応じた表示項目を取得
        $displayItems = CorporationSearchModalDisplayItem::where('screen_id', $request->screen_id)
        ->where('is_visible', true)
        ->orderBy('display_order')
        ->get();

        // 新しいレスポンス形式に合わせて返却
        return response()->json([
            'results' => $corporations,
            'displayItems' => $displayItems
        ]);

    }



    public function downloadCsv(Request $request)
    {
        // scopeFilterに渡すための絞り込み条件
        $filters = $request->only(['corporation_num', 'corporation_name', 'invoice_num']);

        // 並び替えの条件を取得
        $sortBy = session('sort_by', 'id');
        $sortDirection = session('sort_direction', 'asc');

        // モデルにビジネスロジックを寄せて、CSVファイルをダウンロード
        return Corporation::downloadCorporationCsv($filters, $sortBy, $sortDirection);
    }


    // public function exportCsv(Request $request)
    // {
    //     $filters = $request->only(['corporation_num', 'corporation_name']);
    //     ExportCorporationsCsv::dispatch($filters);

    //     // 生成されたファイル名を取得
    //     $filename = 'corporations_' . now()->format('YmdHis') . '.csv';

    //     // ダウンロードページにリダイレクト
    //     return redirect()->route('corporations.index')->with('status', 'エクスポートジョブがディスパッチされました。進捗状況はキューを確認してください。');
    // }

    // public function downloadCsv($filename)
    // {
    //     $path = storage_path('app/' . $filename);
    //     return response()->download($path, $filename)->deleteFileAfterSend(true);
    // }





    public function showUploadForm()
    {
        return view('corporations.upload-form');
    }


    public function upload(CorporationUploadRequest $request)
    {
        session()->forget('validatedErrors');

        $csvFile = $request->file('csv_upload');

        // CSVファイルの一時保存先パス
        $csvPath = $csvFile->getRealPath();

        // ラジオボタンの選択状態を確認
        $radioOption = $request->input('processing_type');

        // 分岐処理
        if ($radioOption === 'new') {
            // 新規登録の処理
            $recordCount = $this->parseCSVAndSaveToDatabase($csvPath, 'new');
        } elseif ($radioOption === 'update') {
            // 既存更新の処理
            $recordCount = $this->parseCSVAndSaveToDatabase($csvPath, 'update');
        } else {
            // バリデーション：更新種別が選択されていない場合（ほぼ起こり得ない）
            return redirect()->back()->with('error', '処理種別が選択されていません。');
        }
        
        if (!is_numeric($recordCount)) {
            // エラーが発生し数値以外が返ってきた（例外がスローされた）場合はリダイレクトしてエラーメッセージを表示
            return redirect()->back()->withInput()->with('error', 'エラーがあります');
        }
    
        // 成功時のリダイレクトやメッセージを追加するなどの処理を行う
        return redirect()->back()->with('success', $recordCount . '件のデータを正常にアップロードしました。');
    }

    private function parseCSVAndSaveToDatabase($csvPath, $operation)
    {
        // BOMを除去するための処理
        $bom = pack('H*','EFBBBF'); // UTF-8のBOM
        if (0 === strncmp($csvPath, $bom, 3)) {
            $csvPath = substr($csvPath, 3);
        }

        // CSV ファイルの文字コードを自動判定
        $fromCharset = mb_detect_encoding(file_get_contents($csvPath), 'UTF-8, Shift_JIS, EUC-JP, JIS, SJIS-win, UTF-16, Unicode', true);

        $config = new LexerConfig();
        $config->setFromCharset($fromCharset)
            ->setEnclosure('"')
            ->setDelimiter(',')
            ->setIgnoreHeaderLine(true);
    
        $lexer = new Lexer($config);
    
        // トランザクション開始
        DB::beginTransaction();
    
        try {
            $recordCount = 0;
            $lineNumber = 1;
            $errors = [];
    
            $interpreter = new Interpreter();
            $interpreter->addObserver(function (array $row) use ($operation, &$recordCount, &$lineNumber, &$errors) {
                $lineNumber++;
    
                $rowErrors = $this->validateRow($row, $operation, $lineNumber);
                if (!empty($rowErrors)) {
                    // 行ごとのエラーを$errorsに追加
                    $errors[$lineNumber] = $rowErrors;
                } else {
                    // エラーがなければ処理を継続し、データを登録する
                    $this->processRow($row, $operation);
                    $recordCount++;
                }
            });
    
            $lexer->parse($csvPath, $interpreter);
    
            // エラーがある場合はトランザクションをロールバックしてエラーメッセージをセッションに保存
            if (!empty($errors)) {
                DB::rollBack();
                $existingErrors = session('validatedErrors', []);
                foreach ($errors as $lineNumber => $lineErrors) {
                    foreach ($lineErrors as $error) {
                        $existingErrors[] = "$lineNumber 行目：$error";
                    }
                }
                session(['validatedErrors' => $existingErrors]);
    
                
                return redirect()->back()->withInput()->with('error', 'エラーがあります');
            }
    
            // トランザクションコミット
            DB::commit();
            return $recordCount;
    
        } catch (\Exception $e) {
            // トランザクションロールバック
            DB::rollBack();
            throw $e;
        }
    }
    
    private function validateRow(array $row, $operation, $lineNumber)
    {
        $errors = [];
    
        // if (count($row) !== 5) {
        //     $errors[] = "列数が5ではない行があります";
        // }

        // 法人番号($row[0])に関して
        if (empty($row[0])) {
            // required
            $errors[] = " 「法人番号」は必須です";
        } elseif (mb_strlen($row[0]) !== 6) {
            // size=6
            $errors[] = " 「法人番号」は6桁でなければなりません";
        }

        if ($operation === 'new' && Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = " 「法人番号」が重複しています";
        }
    
        if ($operation === 'update' && !Corporation::where('corporation_num', $row[0])->exists()) {
            $errors[] = "更新対象の「法人番号」が存在しません";
        }


        // 桁数チェック
        if (mb_strlen($row[1]) > 100) {
            $errors[] = " 「法人名称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[2]) > 100) {
            $errors[] = " 「カナ名称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[3]) > 100) {
            $errors[] = " 「略称」は100文字以下でなければなりません";
        }
        if (mb_strlen($row[4]) > 1000) {
            $errors[] = " 「法人備考」は1000文字以下でなければなりません";
        }

        // 型チェック
        if (!is_string($row[1])) {
            $errors[] = " 「法人名称」は文字列である必要があります";
        }
        if (!is_string($row[2])) {
            $errors[] = " 「カナ名称」は文字列である必要があります";
        }
        if (!is_string($row[3])) {
            $errors[] = " 「略称」は文字列である必要があります";
        }
        if (!is_string($row[4])) {
            $errors[] = " 「法人備考」は文字列である必要があります";
        }
    

        return $errors;
    }
    
    // private function processRow(array $row, $operation)
    // {
    //     if ($existingRecord = Corporation::where('corporation_num', $row[0])->first()) {
    //         $existingRecord->update([
    //             'corporation_name' => $row[1],
    //             'corporation_kana_name' => $row[2],
    //             'corporation_short_name' => $row[3],
    //             'corporation_memo' => $row[4],
    //         ]);
    //     } elseif ($operation === 'new') {
    //         $corporation = new Corporation();
    //         $corporation->corporation_num = $row[0];
    //         $corporation->corporation_name = $row[1];
    //         $corporation->corporation_kana_name = $row[2];
    //         $corporation->corporation_short_name = $row[3];
    //         $corporation->corporation_memo = $row[4];
    //         $corporation->save();
    //     }
    // }
    private function processRow(array $row, $operation)
    {
        $corporationPrefectureId = $row[7];
        $prefectureId = Prefecture::where('id', $corporationPrefectureId)->first();
        if ($prefectureId) {
            $prefecture = $prefectureId->id;
        } else {
            $prefecture = null;
        }

        $data = [
            'corporation_num' => $row[0],
            'corporation_name' => $row[1],
            'corporation_kana_name' => $row[2],
            'corporation_short_name' => $row[3],
            'corporation_tax_num' => $row[4],
            'invoice_num' => $row[5],
            'corporation_post_code' => $row[6],
            'corporation_prefecture_id' => $prefecture,
            'corporation_address1' => $row[8],
            'corporation_memo' => $row[9],
            'tax_status' => $row[10],
        ];

        if ($operation === 'new') {
            // 新規登録の場合は$dataを保存
            Corporation::create($data);
        } elseif ($existingRecord = Corporation::where('corporation_num', $row[0])->first()) {
            // 既存レコードが存在する場合は更新
            $existingRecord->update($data);
        }
    }
}