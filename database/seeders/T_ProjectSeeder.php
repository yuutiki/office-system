<?php

namespace Database\Seeders;

use App\Models\Corporation;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $corporation0 = Corporation::where('corporation_num', '999990')->first();
        $corporation1 = Corporation::where('corporation_num', '999991')->first();
        $corporation2 = Corporation::where('corporation_num', '999992')->first();
        $corporation3 = Corporation::where('corporation_num', '999993')->first();
        $corporation4 = Corporation::where('corporation_num', '999994')->first();


        Project::create([
            'client_id' => '1',
            'project_num' => '999990-C-C01-0001',
            'project_name' => 'バージョンアップ',
            'sales_stage_id' => '1',
            'project_type_id' => '1',
            'accounting_type_id' => '1',
            'distribution_type_id' => '1',
            // 'proposed_order_date' => '',
            // 'proposed_delivery_date' => '',
            // 'proposed_accounting_date' => '',
            // 'proposed_payment_date' => '',
            'billing_corporation_id' => $corporation0->id,
            // 'billing_corporation_name' => '',
            // 'billing_corporation_division_name' => '',
            // 'billing_corporation_person_name' => '',
            // 'billing_head_post_code' => '',
            // 'billing_head_prefecture' => '',
            // 'billing_head_address1' => '',
            'project_memo' => '1',
            'account_department_id' => '1',
            'account_affiliation1_id' => '1',
            'account_affiliation2_id' => '1',
            'account_affiliation3_id' => '1',
            'account_user_id' => '2',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Project::create([
            'client_id' => '2',
            'project_num' => '999991-C-C01-0001',
            'project_name' => 'クラウド移行',
            'sales_stage_id' => '1',
            'project_type_id' => '1',
            'accounting_type_id' => '1',
            'distribution_type_id' => '1',
            // 'proposed_order_date' => '',
            // 'proposed_delivery_date' => '',
            // 'proposed_accounting_date' => '',
            // 'proposed_payment_date' => '',
            'billing_corporation_id' => $corporation1->id,
            // 'billing_corporation_name' => '',
            // 'billing_corporation_division_name' => '',
            // 'billing_corporation_person_name' => '',
            // 'billing_head_post_code' => '',
            // 'billing_head_prefecture' => '',
            // 'billing_head_address1' => '',
            'project_memo' => '1',
            'account_department_id' => '1',
            'account_affiliation1_id' => '1',
            'account_affiliation2_id' => '1',
            'account_affiliation3_id' => '1',
            'account_user_id' => '2',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Project::create([
            'client_id' => '3',
            'project_num' => '999992-C-C01-0001',
            'project_name' => '年間サポート',
            'sales_stage_id' => '1',
            'project_type_id' => '1',
            'accounting_type_id' => '1',
            'distribution_type_id' => '1',
            // 'proposed_order_date' => '',
            // 'proposed_delivery_date' => '',
            // 'proposed_accounting_date' => '',
            // 'proposed_payment_date' => '',
            'billing_corporation_id' => $corporation2->id,
            // 'billing_corporation_name' => '',
            // 'billing_corporation_division_name' => '',
            // 'billing_corporation_person_name' => '',
            // 'billing_head_post_code' => '',
            // 'billing_head_prefecture' => '',
            // 'billing_head_address1' => '',
            'project_memo' => '1',
            'account_department_id' => '1',
            'account_affiliation1_id' => '1',
            'account_affiliation2_id' => '1',
            'account_affiliation3_id' => '1',
            'account_user_id' => '2',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Project::create([
            'client_id' => '4',
            'project_num' => '999993-C-C01-0001',
            'project_name' => '学生カルテ導入',
            'sales_stage_id' => '1',
            'project_type_id' => '1',
            'accounting_type_id' => '1',
            'distribution_type_id' => '1',
            // 'proposed_order_date' => '',
            // 'proposed_delivery_date' => '',
            // 'proposed_accounting_date' => '',
            // 'proposed_payment_date' => '',
            'billing_corporation_id' => $corporation3->id,
            // 'billing_corporation_name' => '',
            // 'billing_corporation_division_name' => '',
            // 'billing_corporation_person_name' => '',
            // 'billing_head_post_code' => '',
            // 'billing_head_prefecture' => '',
            // 'billing_head_address1' => '',
            'project_memo' => '1',
            'account_department_id' => '1',
            'account_affiliation1_id' => '1',
            'account_affiliation2_id' => '1',
            'account_affiliation3_id' => '1',
            'account_user_id' => '2',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Project::create([
            'client_id' => '5',
            'project_num' => '999994-C-C01-0001',
            'project_name' => 'サポート',
            'sales_stage_id' => '1',
            'project_type_id' => '1',
            'accounting_type_id' => '1',
            'distribution_type_id' => '1',
            // 'proposed_order_date' => '',
            // 'proposed_delivery_date' => '',
            // 'proposed_accounting_date' => '',
            // 'proposed_payment_date' => '',
            'billing_corporation_id' => $corporation4->id,
            // 'billing_corporation_name' => '',
            // 'billing_corporation_division_name' => '',
            // 'billing_corporation_person_name' => '',
            // 'billing_head_post_code' => '',
            // 'billing_head_prefecture' => '',
            // 'billing_head_address1' => '',
            'project_memo' => '1',
            'account_department_id' => '1',
            'account_affiliation1_id' => '1',
            'account_affiliation2_id' => '1',
            'account_affiliation3_id' => '1',
            'account_user_id' => '2',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}