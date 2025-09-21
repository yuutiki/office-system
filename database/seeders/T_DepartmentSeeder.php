<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_DepartmentSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Department::create([
            'code' => '100000',
            'name' => 'システムディ',
            'name_kana' => 'システムディ',
            'name_en' => 'SystemD',
            'parent_id' => null,
            'level' => 1,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '110000',
            'name' => '学園ソリューション事業部',
            'name_kana' => 'ガクエンソリューションジギョウブ',
            'name_en' => 'Gakuen',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '120000',
            'name' => '公教育ソリューション事業部',
            'name_kana' => 'コウキョウイクソリューションジギョウブ',
            'name_en' => 'Koukyoiku',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '130000',
            'name' => '公会計ソリューション事業部',
            'name_kana' => 'コウカイケイソリューションジギョウブ',
            'name_en' => 'Koukaikei',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '140000',
            'name' => 'ウェルネスソリューション事業部',
            'name_kana' => 'ウェルネスソリューションジギョウブ',
            'name_en' => 'Wellness',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '150000',
            'name' => 'ソフトエンジニアリング事業部',
            'name_kana' => 'ソフトエンジニアリングジギョウブ',
            'name_en' => 'SoftEngineering',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '160000',
            'name' => '管理本部',
            'name_kana' => 'カンリホンブ',
            'name_en' => '',
            'parent_id' => 1,
            'level' => 2,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '111000',
            'name' => '営業部',
            'name_kana' => 'エイギョウブ',
            'name_en' => 'Sales',
            'parent_id' => 2,
            'level' => 3,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '112000',
            'name' => '東日本営業部',
            'name_kana' => 'ヒガシニホンエイギョウブ',
            'name_en' => 'South-Sales',
            'parent_id' => 2,
            'level' => 3,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '111100',
            'name' => 'マネジメント課',
            'name_kana' => '',
            'name_en' => '',
            'parent_id' => 8,
            'level' => 4,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '111200',
            'name' => 'システムエンジニア課',
            'name_kana' => '',
            'name_en' => '',
            'parent_id' => 8,
            'level' => 4,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '111300',
            'name' => 'テクニカルサポート課',
            'name_kana' => '',
            'name_en' => '',
            'parent_id' => 8,
            'level' => 4,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '112100',
            'name' => 'マネジメント課',
            'name_kana' => '',
            'name_en' => '',
            'parent_id' => 9,
            'level' => 4,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Department::create([
            'code' => '112200',
            'name' => 'システムエンジニア課',
            'name_kana' => '',
            'name_en' => '',
            'parent_id' => 9,
            'level' => 4,
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}