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
        // ユーザーIDのクエリを作成
        $userIdsQuery = DB::table('user_rolegroup')
            ->where('role_group_id', $roleGroup->id)
            ->where('user_id', '!=', 1)// システム管理者を除外する条件を追加
            ->pluck('user_id');

        // ユーザーモデルからIDが$userIdsQueryに含まれるユーザーを取得
        $users = User::whereIn('id', $userIdsQuery)->get();

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
        // RoleGroupを更新
        $roleGroup->update([
            'role_group_code' => $request->role_group_code,
            'role_group_name' => $request->role_group_name,
            'role_group_eng_name' => $request->role_group_eng_name,
            'role_group_memo' => $request->role_group_memo,
            // 他の属性をここに追加
        ]);

        // フォームから送信された権限データを処理して中間テーブルを更新
        foreach ($request->permissions as $functionMenuId => $permissionId) {
            // 中間テーブルの行を更新する
            $roleGroup->functionMenus()->syncWithoutDetaching([$functionMenuId => ['permission_id' => $permissionId]]);
        }

        // return redirect()->route('role-groups.edit', $roleGroup)->with('success','正常に更新しました');
        return redirect()->back()->with('success','正常に更新しました');
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
        // クライアントからのリクエストからグループIDとユーザIDリストを取得
        $groupId = $request->input('role_group_id');
        $userIds = $request->input('user_ids');
    
        // userIds が NULL でないことを確認し、ループ処理を行う
        if (!is_null($userIds)) {
            // ユーザIDリストをループし、中間テーブルに登録
            foreach ($userIds as $userId) {
                // 既存の中間テーブルに同じ組み合わせが存在するかチェック
                $existingRecord = UserRolegroup::where('role_group_id', $groupId)
                    ->where('user_id', $userId)
                    ->exists();
        
                // 既存のレコードが存在しない場合のみ新しいレコードを作成
                if (!$existingRecord) {
                    UserRolegroup::create([
                        'role_group_id' => $groupId,
                        'user_id' => $userId
                    ]);
                }
            }
        
            // 登録が成功した場合は成功レスポンスを返す
            // return response()->json(['message' => 'Users added to group successfully'], 200);
            return redirect()->back()->with('success', '正常にユーザを紐づけました');
        } else {
            // userIds が NULL の場合、何もせずにエラーレスポンスを返す
            // return response()->json(['error' => 'User IDs are required'], 400);
            return redirect()->back()->with('error', 'ユーザIDが必要です');
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
