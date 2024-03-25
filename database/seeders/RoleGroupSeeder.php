<?php

namespace Database\Seeders;

use App\Models\RoleGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleGroup::create([
            'role_group_code' => '1000',
            'role_group_name' => '管理者',
            'role_group_eng_name' => 'Administrators',
            'role_group_memo' => '説明文・・・',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        RoleGroup::create([
            'role_group_code' => '1100',
            'role_group_name' => 'マネージャ',
            'role_group_eng_name' => 'Managers',
            'role_group_memo' => '説明文・・・',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        RoleGroup::create([
            'role_group_code' => '1200',
            'role_group_name' => '一般',
            'role_group_eng_name' => 'Generals',
            'role_group_memo' => '説明文・・・',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        RoleGroup::create([
            'role_group_code' => '1300',
            'role_group_name' => '事務員',
            'role_group_eng_name' => 'OfficeWorkers',
            'role_group_memo' => '説明文・・・',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
