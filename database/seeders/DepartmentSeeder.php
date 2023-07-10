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
            'prefix_code' => 'C',
            'department_name' => '学園ソリューション事業部',
        ]);
        Department::create([
            'prefix_code' => 'S',
            'department_name' => 'ソフトエンジニアリング事業部',
        ]);
        Department::create([
            'prefix_code' => 'E',
            'department_name' => '公教育ソリューション事業部',
        ]);
        Department::create([
            'prefix_code' => 'A',
            'department_name' => '公会計ソリューション事業部',
        ]);
        Department::create([
            'prefix_code' => 'W',
            'department_name' => 'ウェルネスソリューション事業部',
        ]);
    }
}
