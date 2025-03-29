<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesStage;
use Illuminate\Http\Request;
use App\Http\Resources\SalesStageResource;
use App\Http\Resources\SalesStageCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SalesStageController extends Controller
{
    /**
     * 営業段階一覧を取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 検索パラメータ
        $code = $request->input('code');
        $name = $request->input('name');
        
        // ソートパラメータ
        $sortColumn = $request->input('sort_column', 'sales_stage_code');
        $sortDirection = $request->input('sort_direction', 'asc');
        
        // 許可されたソートカラム
        $allowedSortColumns = [
            'sales_stage_code', 
            'sales_stage_name', 
            'updated_at', 
            'updated_by'
        ];
        
        // ソートカラムが許可されていない場合はデフォルトに戻す
        if (!in_array($sortColumn, $allowedSortColumns)) {
            $sortColumn = 'sales_stage_code';
        }
        
        // クエリ構築
        $query = SalesStage::query();
        
        // 更新者を事前に読み込み
        $query->with('updatedBy');
        
        // 検索条件適用
        if ($code) {
            $query->where('sales_stage_code', 'like', "{$code}%");
        }
        
        if ($name) {
            $query->where('sales_stage_name', 'like', "%{$name}%");
        }
        
        // 並び替え適用
        if ($sortColumn === 'updated_by') {
            // リレーション先のカラムでソートする場合は特別な処理
            $query->join('users', 'sales_stages.updated_by', '=', 'users.id')
                  ->orderBy('users.user_name', $sortDirection)
                  ->select('sales_stages.*');
        } else {
            $query->orderBy($sortColumn, $sortDirection);
        }
        
        // ページネーション (10件ずつ)
        $salesStages = $query->paginate(10);
        
        // フロントエンドが理解できる形式に変換
        return [
            'data' => SalesStageResource::collection($salesStages),
            'current_page' => $salesStages->currentPage(),
            'last_page' => $salesStages->lastPage(),
            'per_page' => $salesStages->perPage(),
            'total' => $salesStages->total(),
            'links' => [
                'prev' => $salesStages->previousPageUrl(),
                'next' => $salesStages->nextPageUrl(),
            ]
        ];
    }

    /**
     * 特定の営業段階を取得
     *
     * @param  \App\Models\SalesStage  $salesStage
     * @return \Illuminate\Http\Response
     */
    public function show(SalesStage $salesStage)
    {
        return new SalesStageResource($salesStage);
    }

    /**
     * 営業段階を更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesStage  $salesStage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesStage $salesStage)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'sales_stage_code' => [
                'required',
                'string',
                'max:2',
                Rule::unique('sales_stages')->ignore($salesStage->id)
            ],
            'sales_stage_name' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // 更新処理
        $salesStage->sales_stage_code = $request->sales_stage_code;
        $salesStage->sales_stage_name = $request->sales_stage_name;
        $salesStage->updated_by = auth()->id();  // 現在のユーザーIDを更新者として保存
        $salesStage->save();
        
        return response()->json([
            'message' => '更新が完了しました',
            'data' => new SalesStageResource($salesStage)
        ]);
    }

    /**
     * 営業段階を削除
     *
     * @param  \App\Models\SalesStage  $salesStage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesStage $salesStage)
    {
        // 削除前の確認（依存関係など）が必要な場合はここで実装
        
        // 削除処理
        $salesStage->delete();
        
        return response()->json([
            'message' => '削除が完了しました'
        ]);
    }
}