<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SupportTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportTimeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');

        $searchParams = $request->validate([
            'code' => 'nullable|string|max:5',
            'name' => 'nullable|string|max:50',
            'include_invail' => 'nullable|boolean',
        ]);
        
        // validate済みのパラメーターを使って検索クエリを組み立てる
        $supportTimeQuery = SupportTime::sortable()->with('updatedBy');

        if(!empty($searchParams['code'])) {
            $supportTimeQuery->where('code', 'LIKE', $searchParams['code'] .'%');
        }

        if(!empty($searchParams['name'])) {
            $supportTimeQuery->where('name', 'LIKE', '%' . $searchParams['name'] . '%');
        }

        if (empty($searchParams['include_invail'])) {
            // チェックがない場合 → 有効のみ表示
            $supportTimeQuery->where('is_active', 1);
        }

        $supportTimes = $supportTimeQuery->orderBy('code', 'asc')->paginate($perPage);

        return view('masters.support-time-index',compact('supportTimes'));
    }

    // public function create()
    // {
    //     //
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|size:2|unique:support_times,code,except,code',
            'name' => 'required|max:20',
            'is_active' => 'required|boolean' // 必須で、0または1のみ許可
        ]);
        
        try {
            $supportTime = new SupportTime();
            $supportTime->fill($data)->save();
            
            return redirect()->back()->with('success', '正常に登録しました');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'データの登録に失敗しました。']);
        }
    }

    // public function show(SupportTime $supportTime)
    // {
    //     //
    // }

    // public function edit(SupportTime $supportTime)
    // {
    //     //
    // }

    public function update(Request $request, SupportTime $supportTime)
    {
        $data = $request->validate([
            // 'code' => 'required|size:2|unique:support_times,code,except,code',
            'name' => 'required|max:20',
            'is_active' => 'required|in:0,1', // 必須で、0または1のみ許可
            'updated_at' => 'required' // 楽観ロック用
        ]);
        
        try {
            if ($supportTime->updated_at->format('Y-m-d H:i:s') !== $request->updated_at) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'データが他のユーザーによって更新されています。画面を再読み込みしてください。');
                }

            // updated_atはバリデーション用なので除去
            unset($data['updated_at']);

            $supportTime->fill($data)->save();
            
            return redirect()->back()->with('success', '正常に更新しました');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'データの更新に失敗しました。');
          }
    }

    /**
     * データを削除（物理削除・リファレンスチェック付き）
     */
    public function destroy(SupportTime $supportTime)
    {
        try {
            // 1. 参照チェックを実行
            $referenceCheck = $this->checkReferences($supportTime);
            
            if (!$referenceCheck['canDelete']) {
                return redirect()->back()->with('error', 'このデータは削除できません。' . $referenceCheck['message']);
            }

            // 2. トランザクション内で物理削除を実行
            DB::transaction(function () use ($supportTime) {
                // 物理削除実行
                $supportTime->delete();
            });
            
            return redirect()->back()->with('success', '正常に削除しました');
                
        } catch (QueryException $e) {
            // 外部キー制約違反の場合（二重チェック）
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'このデータは他の場所で使用されているため削除できません。');
            }
            
            return redirect()->back()->with('error', 'データの削除に失敗しました。システム管理者にお問い合わせください。');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '予期しないエラーが発生しました。システム管理者にお問い合わせください。');
        }
    }

    /**
     * 参照チェックを行う
     */
    private function checkReferences(SupportTime $supportTime): array
    {
        $references = [];
        $totalCount = 0;

        // サポートデータでの使用チェック
        $supportCount = DB::table('supports')
            ->where('support_time_id', $supportTime->id)
            ->count();
        
        if ($supportCount > 0) {
            $references[] = "サポートデータ（{$supportCount}件）";
            $totalCount += $supportCount;
        }

        // 結果を返す
        if (empty($references)) {
            return [
                'canDelete' => true,
                'message' => '',
                'totalCount' => 0
            ];
        } else {
            return [
                'canDelete' => false,
                'message' => '以下の場所で使用されています: ' . implode('、', $references),
                'references' => $references,
                'totalCount' => $totalCount
            ];
        }
    }
}
