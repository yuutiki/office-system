<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * 部門一覧
     */
    public function index(Request $request)
    {
        // フィルタ条件
        $level = $request->input('level');

        // 再帰的に階層順に取得
        $departmentTree = Department::getTree();

        $departments = Department::getHierarchy();

        // level 絞り込みが指定されていればフィルタ
        if (!is_null($level) && $level !== '') {
            $departments = $departments->where('level', $level);
        }

        // プルダウン用 distinct
        $levels = Department::select('level')->distinct()->orderBy('level')->pluck('level');

        return view('masters.departments.index', compact('departments', 'levels', 'level', 'departmentTree'));
    }


    /**
     * 部門作成フォーム
     */
    public function create()
    {
        $departments = Department::orderBy('level')->get();
        $settings = DepartmentSetting::getSettings();

        return view('masters.departments.create', compact('departments', 'settings'));
    }

    /**
     * 部門登録処理
     */
    public function store(Request $request)
    {
        $settings = DepartmentSetting::getSettings();

        $request->validate([
            'code' => [
                'required',
                'string',
                'size:' . $settings->code_length,
                'unique:departments,code', // 階層関係なくユニーク
            ],
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:departments,id',
        ]);

        $parent = Department::find($request->parent_id);

        // 階層制限チェック
        $level = $parent ? $parent->level + 1 : 1;
        if ($level > $settings->max_level) {
            return redirect()->back()
                ->withErrors(['error' => '部門は最大 ' . $settings->max_level . ' 階層までしか作成できません'])
                ->withInput();
        }

        Department::create([
            'code' => $request->code,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'level' => $parent ? $parent->level + 1 : 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', '部門を登録しました');
    }

    /**
     * 部門編集フォーム
     */
    public function edit(Department $department)
    {
        // 自分自身とその子部門を除外した部門リストを取得
        $childrenIds = $this->getChildrenIds($department);
        $excludeIds = array_merge([$department->id], $childrenIds);
        
        $parentDepartments = Department::whereNotIn('id', $excludeIds)
            ->orderBy('level')
            ->get();

        return view('masters.departments.edit', compact('department', 'parentDepartments'));
    }

    /**
     * 部門更新処理
     */
    public function update(Request $request, Department $department)
    {
        $settings = DepartmentSetting::getSettings();

        $request->validate([
            'code' => [
                'required',
                'string',
                'size:' . $settings->code_length,
                // Rule::unique('departments', 'code')->ignore($department->id), // 自分以外でユニーク
            ],
            'name' => 'required|string|max:100',
            'parent_id' => [
                'nullable',
                'exists:departments,id',
                function ($attribute, $value, $fail) use ($department, $settings) {
                    if ($value == $department->id) {
                        $fail('自分自身を親部門に設定することはできません。');
                    }
                    if ($value && $department->wouldCreateCircularReference($value)) {
                        $fail('循環参照が発生するため、この部門を親に設定できません。');
                    }
                    if ($value) {
                        $parent = Department::find($value);
                        $newLevel = $parent ? $parent->level + 1 : 1;
                        if ($newLevel > $settings->max_level) {
                            $fail('部門は最大 ' . $settings->max_level . ' 階層までしか作成できません。');
                        }
                    }
                }
            ],
            'description' => 'nullable|string|max:500',
        ]);


        DB::beginTransaction();
        try {
            $oldParentId = $department->parent_id;
            $newParentId = $request->parent_id;

            $parent = $newParentId ? Department::find($newParentId) : null;
            $newLevel = $parent ? $parent->level + 1 : 1;

            // 最大階層チェック（自分と子孫すべて）
            if ($department->wouldExceedMaxLevel($newLevel, $settings->max_level)) {
                DB::rollBack();
                return redirect()->back()
                    ->withErrors(['error' => 'この部門を移動すると最大階層数を超えてしまいます'])
                    ->withInput();
            }

            // 部門情報を更新
            $department->update([
                'code'        => $request->code,
                'name'        => $request->name,
                'parent_id'   => $newParentId,
                'level'       => $newLevel,
                'description' => $request->description,
                'is_active'   => $request->has('is_active'),
            ]);

            // 子孫も再帰的に更新
            if ($oldParentId != $newParentId) {
                $department->updateHierarchyLevels();
            }

            DB::commit();
            return redirect()->route('departments.index')->with('success', '部門を更新しました');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => '部門の更新に失敗しました'])->withInput();
        }


    }

    /**
     * 部門削除処理
     */
    public function destroy(Department $department)
    {
        DB::beginTransaction();
        try {
            // 子部門があるかチェック
            if ($department->children()->exists()) {
                return redirect()->back()->withErrors(['error' => '子部門が存在するため削除できません']);
            }

            // 関連データの確認（例：従業員が所属している場合）
            // if ($department->employees()->exists()) {
            //     return redirect()->back()->withErrors(['error' => 'この部門に所属する従業員がいるため削除できません']);
            // }

            $department->delete();

            DB::commit();
            return redirect()->route('departments.index')->with('success', '部門を削除しました');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => '部門の削除に失敗しました']);
        }
    }

    /**
     * 指定した部門のすべての子部門IDを取得
     */
    private function getChildrenIds(Department $department)
    {
        $childrenIds = [];
        $this->collectChildrenIds($department, $childrenIds);
        return $childrenIds;
    }

    /**
     * 再帰的に子部門IDを収集
     */
    private function collectChildrenIds(Department $department, &$childrenIds)
    {
        foreach ($department->children as $child) {
            $childrenIds[] = $child->id;
            $this->collectChildrenIds($child, $childrenIds);
        }
    }
}
