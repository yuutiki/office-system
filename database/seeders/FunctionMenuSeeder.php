<?php

namespace Database\Seeders;

use App\Models\FunctionMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunctionMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FunctionMenu::create([
            'function_menu_code' => '1000',
            'function_menu_name' => '法人管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1010',
            'function_menu_name' => '顧客管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1020',
            'function_menu_name' => '業者管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1030',
            'function_menu_name' => '顧客担当者管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1040',
            'function_menu_name' => '業者担当者管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1050',
            'function_menu_name' => 'サポート管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1060',
            'function_menu_name' => '契約管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1070',
            'function_menu_name' => 'プロジェクト管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1080',
            'function_menu_name' => '発注管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1090',
            'function_menu_name' => '営業報告管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1100',
            'function_menu_name' => '工数管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1110',
            'function_menu_name' => '預託管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1120',
            'function_menu_name' => 'ユーザ管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1130',
            'function_menu_name' => '権限グループ管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1140',
            'function_menu_name' => '製品管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1150',
            'function_menu_name' => 'リンク管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        FunctionMenu::create([
            'function_menu_code' => '1160',
            'function_menu_name' => 'マスタ管理',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}