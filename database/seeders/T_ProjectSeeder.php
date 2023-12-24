<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'client_id' => '1',
            'project_num' => '100102-C01-0001',
            'project_name' => '【CUS.】寄付金管理システム',
            'sales_stage_id' => '1',
            'accounting_type_id' => '1',
            'project_type_id' => '1',
            'company_id' => '1',
            'department_id' => '1',
            'division_id' => '1',
            'project_memo' => 'テスト',
            'user_id' => '1',
            'distribution_type_id' => '1',
            'client_budget_year' => '2024',
            'accounting_start_date' => '2024-11-01',
            'accounting_end_date' => '2025-10-01',
            'revenue_distribution_set2_11' => '0'
        ]);
    }
}
