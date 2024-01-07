<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'department_code' => '11',
            'prefix_code' => 'C',
            'department_name' => '学園ソリューション事業部',
            'department_kana_name' => 'ガクエンソリューションジギョウブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Department::create([
            'department_code' => '12',
            'prefix_code' => 'S',
            'department_name' => 'ソフトエンジニアリング事業部',
            'department_kana_name' => 'ソフトエンジニアリングジギョウブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Department::create([
            'department_code' => '13',
            'prefix_code' => 'E',
            'department_name' => '公教育ソリューション事業部',
            'department_kana_name' => 'コウキョウイクソリューションジギョウブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Department::create([
            'department_code' => '14',
            'prefix_code' => 'A',
            'department_name' => '公会計ソリューション事業部',
            'department_kana_name' => 'コウカイケイソリューションジギョウブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Department::create([
            'department_code' => '15',
            'prefix_code' => 'W',
            'department_name' => 'ウェルネスソリューション事業部',
            'department_kana_name' => 'ウェルネスソリューションジギョウブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Department::create([
            'department_code' => '90',
            'prefix_code' => 'M',
            'department_name' => '管理本部',
            'department_kana_name' => 'カンリホンブ',
            'department_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
