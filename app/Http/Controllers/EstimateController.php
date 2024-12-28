<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateAddress;
use App\Models\EstimateDetail;
use App\Models\Product;
use App\Models\ProductSeries;
use App\Models\ProductSplitType;
use App\Models\ProductType;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;

class EstimateController extends Controller
{
    public function index()
    {
        //
    }

    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        $productSeries = ProductSeries::all();
        $productType = ProductType::all();
        $productSplitTypes = ProductSplitType::all();
        $estimateAddresses = EstimateAddress::where('project_affiliation1', $project->account_affiliation1_id)
        ->where(function ($query) use ($project) {
            $query->where('project_affiliation2', $project->account_affiliation2_id)
                  ->orWhereNull('project_affiliation2');
        })
        ->where(function ($query) use ($project) {
            $query->where('project_affiliation3', $project->account_affiliation3_id)
                  ->orWhereNull('project_affiliation3');
        })
        ->where(function ($query) use ($project) {
            $query->where('project_affiliation4', $project->account_affiliation4_id)
                  ->orWhereNull('project_affiliation4');
        })
        ->where(function ($query) use ($project) {
            $query->where('project_affiliation5', $project->account_affiliation5_id)
                  ->orWhereNull('project_affiliation5');
        })
        ->get();

        $defaultEstimateMemo ="■内容等変更が生じた場合は再度御見積りが必要となります。\n■消費税率が改定される際は別途御見積り致します。";

        return view('estimate.create', compact('productSeries', 'productType' ,'productSplitTypes', 'project', 'estimateAddresses', 'defaultEstimateMemo'));
    }

    public function store(Request $request, $projectId)
    {
        // バリデーション（必要に応じて追加）
        // $validatedData = $request->validate([
        //     // バリデーションルール
        // ]);

        DB::beginTransaction(); // トランザクション開始

        try {
            // 親モデルのデータを作成
            $estimateNum = Estimate::generateEstimateNumber($projectId);

            $estimate = new Estimate;
            $estimate->project_id = $projectId;
            $estimate->estimate_num = $estimateNum;
            $estimate->estimate_subject = $request->estimate_subject;
            $estimate->estimate_at = $request->estimate_at;
            $estimate->estimate_recipient = $request->estimate_recipient;

            $estimate->delivery_place = $request->delivery_place;
            $estimate->delivery_at = $request->delivery_at;
            $estimate->transaction_method = $request->transaction_method;
            $estimate->expiration_at = $request->expiration_at;

            $estimate->total_without_tax = str_replace(',', '', $request->total_without_tax);
            $estimate->total_tax = str_replace(',', '', $request->total_tax);
            $estimate->total_with_tax = str_replace(',', '', $request->total_with_tax);

            $estimate->estimate_memo = $request->estimate_memo;
            // $estimate->estimate_sheet = $request->estimate_sheet;
            $estimate->estimate_address_id = $request->estimate_address_id;
            $estimate->custom_user_id = $request->custom_user_id;
            $estimate->user_position_name = $request->user_position_name;
            $estimate->estimate_document_title = $request->estimate_document_title;
            $estimate->order_document_title = $request->order_document_title;
            $estimate->save(); // 見積書を保存

            // 明細データの処理
            $sortOrders = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^sort-order-(\d+)$/', $key, $matches)) {
                    $sortOrders[$matches[1]] = $value;
                }
            }


            $details = [];
            foreach ($sortOrders as $index => $sortOrder) {
                $i = $index - 1 + 1;
            
                $productCode = $request->input("ing-cd-$i");
            
                // 製品コードに基づいて製品IDを取得
                $product = Product::where('product_code', $productCode)->first();
                $productId = $product ? $product->id : null;
            
                $ulid = (string) Str::ulid();
            
                $details[] = [
                    'ulid' => $ulid,
                    'estimate_id' => $estimate->ulid,
                    'product_id' => $productId,
                    'product_name' => $request->input("ing-name-$i"),
                    'product_model_num' => $request->input("ing-kataban-$i"),
                    'unit_price' => $this->convertToDecimal($request->input("ing-tanka-$i")),  // 標準単価
                    'unit_cost' => $this->convertToDecimal($request->input("ing-genka-$i")),   // 原価
                    'quantity' => $request->input("ing-suryo-$i"),
                    'discount' => $this->convertToDecimal($request->input("ing-nebiki-$i") ?? '0'),
                    'sort_order' => $sortOrder,
                ];
            }
            



            // 明細データを一括で保存
            EstimateDetail::insert($details);

            DB::commit(); // トランザクションをコミット

        // 新しく作成された見積書の編集画面にリダイレクト
        return redirect()->route('estimates.edit', ['projectId' => $projectId, 'estimateId' => $estimate->ulid])
                         ->with('success', '見積書と明細が正常に保存されました。');

        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック
    
            // エラー内容をログに記録
            \Log::error('見積書と明細の保存中にエラーが発生しました: ' . $e->getMessage(), [
                'request_data' => $request->all(), // リクエストデータをログに含める
                'error_trace' => $e->getTraceAsString() // エラーのスタックトレースをログに含める
            ]);
    
            // エラーの詳細をクライアントに返す（適切なメッセージに変更する）
            // return response()->json(['error' => '見積書と明細の保存中にエラーが発生しました。詳細はログを確認してください。'], 500);
            return redirect()->back()->withInput()->with('error', 'エラーがあります');
        }
    }

    private function convertToDecimal($value)
    {
        // 空の文字列またはNULL、または0の場合にNULLを返す
        return $value === '' || $value === null || $value == 0 ? null : str_replace(',', '', $value);
    }

    public function show(Estimate $estimate)
    {
        //
    }

    public function edit($projectId, $estimateId)
    {
        $project = Project::findOrFail($projectId);
        $estimate = Estimate::findOrFail($estimateId);
        $productSeries = ProductSeries::all();
        $productType = ProductType::all();
        $productSplitTypes = ProductSplitType::all();
        $users = User::all();
        $estimateAddresses = EstimateAddress::where('project_affiliation1', $project->account_affiliation1_id)
        ->where('project_affiliation2', $project->account_affiliation2_id)
        ->where('project_affiliation3', $project->account_affiliation3_id)
        ->where('project_affiliation4', $project->account_affiliation4_id)
        ->where('project_affiliation5', $project->account_affiliation5_id)
        ->get();

    
        // 関連する明細データを取得
        $estimateDetails = $estimate->details()->orderBy('sort_order')->get();
    
        return view('estimate.edit', compact('estimate', 'estimateDetails', 'productSeries', 'productType', 'productSplitTypes', 'project', 'estimateAddresses', 'users'));
    }

    public function update(Request $request, Estimate $estimate, $projectId, $estimateId)
    {
        // バリデーション（必要に応じて追加）
        // $validatedData = $request->validate([
        //     // バリデーションルール
        // ]);

        DB::beginTransaction(); // トランザクション開始

        try {
            $estimate = Estimate::findOrFail($estimateId);

            // 親モデルのデータを更新
            $estimate->estimate_subject = $request->estimate_subject;
            $estimate->estimate_recipient = $request->estimate_recipient;
            $estimate->estimate_at = $request->estimate_at;
            $estimate->submit_at = $request->submit_at;
            $estimate->total_without_tax = str_replace(',', '', $request->total_without_tax);
            $estimate->total_tax = str_replace(',', '', $request->total_tax);
            $estimate->total_with_tax = str_replace(',', '', $request->total_with_tax);
            $estimate->estimate_memo = $request->estimate_memo;
            // $estimate->estimate_sheet = $request->estimate_sheet;

            //見積条件
            $estimate->delivery_place = $request->delivery_place;
            $estimate->delivery_at = $request->delivery_at;
            $estimate->transaction_method = $request->transaction_method;
            $estimate->expiration_at = $request->expiration_at; // 有効期限

            // 見積書設定
            $estimate->estimate_address_id = $request->estimate_address_id;
            $estimate->custom_user_id = $request->custom_user_id;
            $estimate->user_position_name = $request->user_position_name;
            $estimate->estimate_document_title = $request->estimate_document_title;

            // 注文書設定
            $estimate->order_document_title = $request->order_document_title;


            $estimate->save();

            // 既存の明細を削除
            $estimate->details()->delete();

            // 明細データの処理
            $sortOrders = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^sort-order-(\d+)$/', $key, $matches)) {
                    $sortOrders[$matches[1]] = $value;
                }
            }

            $details = [];

            foreach ($sortOrders as $index => $sortOrder) {
                $i = $index-1 + 1;

                $productCode = $request->input("ing-cd-$i");

                // 製品コードに基づいて製品IDを取得
                $product = Product::where('product_code', $productCode)->first();
                if ($product) {
                    $productId = $product->id;
                } else {
                    $productId = $product ? $product->id : null;
                    // throw new \Exception("製品コード '$productCode' に対応する製品が見つかりません。");
                }

                $ulid = (string) Str::ulid();

                $details[] = [
                    'ulid' => $ulid,
                    'estimate_id' => $estimate->ulid,
                    'product_id' => $productId,
                    'product_name' => $request->input("product-name-$i"),
                    'product_model_num' => $request->input("model-number-$i"),
                    'unit_price' =>  $this->convertToDecimal($request->input("unit-price-$i")),
                    'unit_cost' =>  $this->convertToDecimal($request->input("unit-cost-$i")),
                    'quantity' => $request->input("quantity-$i"),
                    'discount' =>  $this->convertToDecimal($request->input("discount-$i") ?? '0'),
                    'sort_order' => $sortOrder,
                ];
            }

            // 新しい明細データを一括で保存
            EstimateDetail::insert($details);

            DB::commit(); // トランザクションをコミット

            return redirect()->route('estimates.edit', ['projectId' => $projectId, 'estimateId' => $estimateId])->with('success', '見積書が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック
    
            // エラー内容をログに記録
            \Log::error('見積書と明細の保存中にエラーが発生しました: ' . $e->getMessage(), [
                'request_data' => $request->all(), // リクエストデータをログに含める
                'error_trace' => $e->getTraceAsString() // エラーのスタックトレースをログに含める
            ]);
    
            // エラーの詳細をクライアントに返す（適切なメッセージに変更する）
            // return response()->json(['error' => '見積書と明細の保存中にエラーが発生しました。詳細はログを確認してください。'], 500);
            return redirect()->back()->withInput()->with('error', 'エラーがあります');
        }
    }

    public function destroy(Estimate $estimate)
    {
        // $estimate = Client::find($id);
        $estimate->delete();

        return redirect()->back()->with('success', '正常に削除しました');
    }

    public function generatePdf(Estimate $estimate)
    {
        // EstimateモデルからDBの値を取得
        $estimateDetailData = $estimate->details()->orderBy('sort_order')->get();
        $estimate->formatted_date = Carbon::parse($estimate->estimate_at)->format('Y年 n月 j日');
    
        // PDF設定
        $config = [
            // 'mode' => 'utf-8',
            // 'default_font' => 'ipaexg',  // ここで日本語対応フォントを指定
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_left' => 10,
            'margin_bottom' => 20,  // フッター用の余白
            'margin_footer' => 10,  // フッターの高さ
            'tempDir' => storage_path('app/pdf-temp'),
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ];
    
        // フッターテンプレートを読み込む
        $footerHtml = view('pdf.footer', compact('estimate'))->render();
    
        // カスタムPDFインスタンスを作成
        $pdf = new \Mpdf\Mpdf($config);
    
        // フッターを設定（コンテンツ生成前に行う）
        $pdf->SetHTMLFooter($footerHtml);
    
        // コンテンツを生成
        $content = view('pdf.estimate1-main', compact('estimate', 'estimateDetailData'))->render();
    
        // コンテンツを書き込む
        $pdf->WriteHTML($content);
    
        // PDFをストリームとして出力
        return new \Illuminate\Http\Response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="estimate_' . $estimate->ulid . '.pdf"',
        ]);
    }

    public function downloadPdf(Estimate $estimate)
    {
        // EstimateモデルからDBの値を取得
        $estimateDetailData = $estimate->details()->orderBy('sort_order')->get();
        $estimate->formatted_date = Carbon::parse($estimate->estimate_at)->format('Y年 n月 j日');
    
        // PDF設定
        $config = [
            'margin_top' => 10,
            'margin_right' => 10,
            'margin_left' => 10,
            'margin_bottom' => 20,  // フッター用の余白
            'margin_footer' => 10,  // フッターの高さ
            'tempDir' => storage_path('app/pdf-temp'),
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ];
    
        // フッターテンプレートを読み込む
        $footerHtml = view('pdf.footer', compact('estimate'))->render();
    
        // カスタムPDFインスタンスを作成
        $pdf = new \Mpdf\Mpdf($config);
    
        // フッターを設定（コンテンツ生成前に行う）
        $pdf->SetHTMLFooter($footerHtml);
    
        // コンテンツを生成
        $content = view('pdf.estimate1-main', compact('estimate', 'estimateDetailData'))->render();
    
        // コンテンツを書き込む
        $pdf->WriteHTML($content);
    
        // PDFをダウンロードとして出力
        return new \Illuminate\Http\Response($pdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="estimate_' . $estimate->ulid . '.pdf"',
        ]);
    }
}
