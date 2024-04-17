<?php

namespace Database\Seeders;

use App\Models\FunctionMenu;
use App\Models\Permission;
use App\Models\RoleGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleGroupSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->createRoleGroup('1000', '管理者', 'Administrators', '運用管理者用');
        $this->createRoleGroup('1100', 'マネージャ', 'Managers', '役職者用');
        $this->createRoleGroup('1200', '一般', 'Generals', '一般社員用');
        $this->createRoleGroup('1300', '事務員', 'OfficeWorkers', '事務作業用');
    }

    /**
     * Create a role group and associate with function menus
     *
     * @param string $code
     * @param string $name
     * @param string $engName
     * @param string $memo
     * @return void
     */
    private function createRoleGroup($code, $name, $engName, $memo): void
    {
        $roleGroup = RoleGroup::create([
            'role_group_code' => $code,
            'role_group_name' => $name,
            'role_group_eng_name' => $engName,
            'role_group_memo' => $memo,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 全てのFunctionMenuを取得
        $functionMenus = FunctionMenu::all();

        // パーミッションテーブルから権限なしのレコードを取得
        $permissionNone = Permission::where('permission_code', '00')->first();

        // 各FunctionMenuとRoleGroupを関連付ける
        foreach ($functionMenus as $functionMenu) {
            $roleGroup->functionMenus()->attach($functionMenu->id, ['permission_id' => $permissionNone->id]);
        }
    }
}