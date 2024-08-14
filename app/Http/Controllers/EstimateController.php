<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateDetail;
use App\Models\Product;
use App\Models\ProductSeries;
use App\Models\ProductSplitType;
use App\Models\ProductType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

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

        return view('estimate.create', compact('productSeries', 'productType' ,'productSplitTypes', 'project'));
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
            $estimate->estimate_title = $request->estimate_title;
            $estimate->estimate_at = $request->estimate_at;
            $estimate->submit_at = $request->submit_at;
            $estimate->subtotal_amount = str_replace(',', '', $request->total_without_tax);
            $estimate->tax_amount = str_replace(',', '', $request->total_tax);
            $estimate->total_amount = str_replace(',', '', $request->total_with_tax);
            $estimate->delivery_place = $request->delivery_place;
            $estimate->delivery_at = $request->delivery_at;
            $estimate->transaction_method = $request->transaction_method;
            $estimate->expiration_at = $request->expiration_at;
            $estimate->estimate_memo = $request->estimate_memo;
            $estimate->estimate_sheet = $request->estimate_sheet;
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
                $i = $index-1 + 1;

                $productCode = $request->input("ing-cd-$i");

                // 製品コードに基づいて製品IDを取得
                $product = Product::where('product_code', $productCode)->first();
                if ($product) {
                    $productId = $product->id;
                } else {
                    // 製品コードが見つからない場合の処理（エラー処理など）
                    throw new \Exception("製品コード '$productCode' に対応する製品が見つかりません。");
                }

                $ulid = (string) Str::ulid();

                $details[] = [
                    'ulid' => $ulid,
                    'estimate_id' => $estimate->ulid, // 親のulidを設定
                    'product_id' => $productId, // 取得した製品IDを使用
                    'product_name' => $request->input("ing-name-$i"),
                    'product_model_num' => $request->input("ing-kataban-$i"),
                    'unit_price' => str_replace(',', '', $request->input("ing-tanka-$i")),
                    'unit_cost' => str_replace(',', '', $request->input("ing-genka-$i")),
                    'quantity' => $request->input("ing-suryo-$i"),
                    'discount' => str_replace(',', '', $request->input("ing-nebiki-$i") ?? '0'),
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
    
        // 関連する明細データを取得
        $estimateDetails = $estimate->details()->orderBy('sort_order')->get();
    
        return view('estimate.edit', compact('estimate', 'estimateDetails', 'productSeries', 'productType', 'productSplitTypes', 'project'));
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
            $estimate->estimate_title = $request->estimate_title;
            $estimate->estimate_at = $request->estimate_at;
            $estimate->submit_at = $request->submit_at;
            $estimate->subtotal_amount = str_replace(',', '', $request->total_without_tax);
            $estimate->tax_amount = str_replace(',', '', $request->total_tax);
            $estimate->total_amount = str_replace(',', '', $request->total_with_tax);
            $estimate->delivery_place = $request->delivery_place;
            $estimate->delivery_at = $request->delivery_at;
            $estimate->transaction_method = $request->transaction_method;
            $estimate->expiration_at = $request->expiration_at;
            $estimate->estimate_memo = $request->estimate_memo;
            $estimate->estimate_sheet = $request->estimate_sheet;
            $estimate->save(); // 更新を保存

            // 既存の明細を削除
            $estimate->estimateDetails()->delete();

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
                    throw new \Exception("製品コード '$productCode' に対応する製品が見つかりません。");
                }

                $ulid = (string) Str::ulid();

                $details[] = [
                    'ulid' => $ulid,
                    'estimate_id' => $estimate->ulid,
                    'product_id' => $productId,
                    'product_name' => $request->input("ing-name-$i"),
                    'product_model_num' => $request->input("ing-kataban-$i"),
                    'unit_price' => str_replace(',', '', $request->input("ing-tanka-$i")),
                    'unit_cost' => str_replace(',', '', $request->input("ing-genka-$i")),
                    'quantity' => $request->input("ing-suryo-$i"),
                    'discount' => str_replace(',', '', $request->input("ing-nebiki-$i") ?? '0'),
                    'sort_order' => $sortOrder,
                ];
            }

            // 新しい明細データを一括で保存
            EstimateDetail::insert($details);

            DB::commit(); // トランザクションをコミット

            return redirect()->route('estimates.show', ['projectId' => $projectId, 'estimateId' => $estimateId])->with('success', '見積書が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック

            // エラー内容をログに記録
            \Log::error('見積書と明細の更新中にエラーが発生しました: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error_trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => '見積書と明細の更新中にエラーが発生しました。詳細はログを確認してください。']);
        }
    }

    public function destroy(Estimate $estimate)
    {
        //
    }

    public function generatePdf()
    {
        $data = [
            'atesaki' => '田中学園'
        ];
        //ここでviewに$dataを送っているけど、
        //今回$dataはviewで使わない
        $pdf = PDF::loadView('pdf.document', $data);

        return $pdf->stream('document.pdf'); //生成されるファイル名
    }
}
