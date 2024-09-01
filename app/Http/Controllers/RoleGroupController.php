<?php

namespace App\Http\Controllers;

use App\Models\Affiliation1;
use App\Models\Affiliation2;
use App\Models\Affiliation3;
use App\Models\FunctionMenu;
use App\Models\Permission;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\UserRolegroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleGroups = RoleGroup::orderBy('role_group_code', 'asc')->paginate(50);
        return view('admin.role-groups.index',compact('roleGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // RoleGroupを作成
        $roleGroup = RoleGroup::create([
            'role_group_code' => $request->role_group_code,
            'role_group_name' => $request->role_group_name,
            'role_group_eng_name' => $request->role_group_eng_name,
            'role_group_memo' => $request->role_group_memo,
            // 他の属性をここに追加
        ]);
    
        // 全てのFunctionMenuを取得
        $functionMenus = FunctionMenu::all();
    
        // パーミッションテーブルから権限なしのレコードを取得
        $permissionNone = Permission::where('permission_code', '00')->first();
    
        // 各FunctionMenuとRoleGroupを関連付ける
        foreach ($functionMenus as $functionMenu) {
            $roleGroup->functionMenus()->attach($functionMenu->id, ['permission_id' => $permissionNone->id]);
        }
    
        return redirect()->route('role-groups.index');        
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleGroup $roleGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleGroup $roleGroup, Request $request)
    {
        $users = User::whereHas('roleGroups', function ($query) use ($roleGroup) {
            $query->where('role_groups.id', $roleGroup->id);
        })
        ->where('id', '!=', 1) // システム管理者を除外
        ->with(['affiliation1', 'affiliation2', 'affiliation3'])
        ->paginate(50);
    
        $roleGroup->load(['functionMenus.permission']);

        // ユーザ検索条件を渡す
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();


        // RoleGroupに関連付けられたFunctionMenuを取得
        $functionMenus = $roleGroup->functionMenus;

        // FunctionMenuとPermissionの関連情報を取得
        foreach ($functionMenus as $functionMenu) {
            // function_menu_role_groupからpermission_idを取得
            $permission = $functionMenu->pivot->permission_id;
            // Permissionモデルから該当する権限を取得して関連付ける
            $functionMenu->permission = Permission::find($permission);
        }

                    // パーミッションを取得
        $permissions = Permission::all();


        // // ロールグループIDに関連するユーザーデータを取得
        // $users = User::whereHas('roleGroups', function ($query) use ($roleGroup) {
        //     $query->where('role_groups.id', $roleGroup->id);
        // })->get();
        $activeTab = $request->query('tab', 'tab1'); // クエリパラメータからタブを取得


        return view('admin.role-groups.edit', compact('roleGroup', 'users', 'affiliation1s', 'affiliation2s', 'affiliation3s','functionMenus','permissions','activeTab',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleGroup $roleGroup)
    {
        DB::beginTransaction();
    
        try {
            // RoleGroupを更新
            $roleGroup->update([
                'role_group_code' => $request->role_group_code,
                'role_group_name' => $request->role_group_name,
                'role_group_eng_name' => $request->role_group_eng_name,
                'role_group_memo' => $request->role_group_memo,
            ]);
    
            // 権限データをチャンクで処理
            $chunkSize = 100; // 調整可能
            collect($request->permissions)->chunk($chunkSize)->each(function ($chunk) use ($roleGroup) {
                $updates = [];
                foreach ($chunk as $functionMenuId => $permissionId) {
                    $updates[] = [
                        'role_group_id' => $roleGroup->id,
                        'function_menu_id' => $functionMenuId,
                        'permission_id' => $permissionId,
                    ];
                }
                
                // 一括更新
                DB::table('function_menu_role_group')->upsert(
                    $updates,
                    ['role_group_id', 'function_menu_id'],
                    ['permission_id']
                );
            });
    
            DB::commit();
            return redirect()->back()->with('success', '正常に更新しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', '更新に失敗しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleGroup $roleGroup)
    {
        //
    }

    // GroupControllerのaddUsersToGroupメソッド
    public function addUsersToGroup(Request $request)
    {
        $groupId = $request->input('role_group_id');
        $userIds = $request->input('user_ids');
    
        if (empty($userIds)) {
            return redirect()->back()->with('error', 'ユーザIDが必要です');
        }
    
        $chunkSize = 500; // 調整可能
        $totalAdded = 0;
    
        DB::beginTransaction();
    
        try {
            foreach (array_chunk($userIds, $chunkSize) as $chunk) {
                // 既存のレコードを一括で取得
                $existingRecords = UserRolegroup::where('role_group_id', $groupId)
                    ->whereIn('user_id', $chunk)
                    ->pluck('user_id')
                    ->toArray();
    
                // 新しく追加する必要があるユーザーIDのみをフィルタリング
                $newUserIds = array_diff($chunk, $existingRecords);
    
                if (!empty($newUserIds)) {
                    // 新しいレコードを一括で作成
                    $newRecords = array_map(function($userId) use ($groupId) {
                        return [
                            'role_group_id' => $groupId,
                            'user_id' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }, $newUserIds);
    
                    // 一括挿入
                    UserRolegroup::insert($newRecords);
    
                    $totalAdded += count($newUserIds);
                }
    
                // メモリの解放
                unset($existingRecords, $newUserIds, $newRecords);
            }
    
            DB::commit();
            return redirect()->back()->with('success', $totalAdded . '人のユーザを正常に紐づけました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add users to group: ' . $e->getMessage());
            return redirect()->back()->with('error', 'ユーザの紐づけに失敗しました: ' . $e->getMessage());
        }
    }



    public function deleteUserFromGroup(Request $request)
    {
        // フォームから送信されたユーザIDとグループIDを取得
        $userId = $request->input('user_id');
        $groupId = $request->input('role_group_id');
    
        // 中間テーブルの行を削除
        UserRolegroup::where('user_id', $userId)->where('role_group_id', $groupId)->delete();
    
        return redirect()->back()->with('success', 'ユーザをグループから削除しました');
    }

    public function searchRoleGroups(Request $request)
    {
        $roleGroupCode = $request->role_group_code;
        $roleGroupName = $request->role_group_name;
        $roleGroupEngName = $request->role_group_eng_name;

        $roleGroups = RoleGroup::where('role_group_code', 'like', '%' . $roleGroupCode . '%')
            ->where('role_group_name', 'like', '%' . $roleGroupName . '%')
            ->where('role_group_name', 'like', '%' . $roleGroupEngName . '%')
            ->get();

        // 検索結果をJSON形式で返す
        return response()->json($roleGroups);
    }

}
