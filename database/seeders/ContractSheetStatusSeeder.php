<?php

namespace Database\Seeders;

use App\Models\ContractSheetStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSheetStatusSeeder extends Seeder
{
    public function run(): void
    {
        ContractSheetStatus::create([
            'contract_sheet_status_code' => '10',
            'contract_sheet_status_name' => '未返送',
            'contract_sheet_status_name_en' => 'Not returned',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractSheetStatus::create([
            'contract_sheet_status_code' => '20',
            'contract_sheet_status_name' => '返送済',
            'contract_sheet_status_name_en' => 'Returned',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractSheetStatus::create([
            'contract_sheet_status_code' => '30',
            'contract_sheet_status_name' => '継続',
            'contract_sheet_status_name_en' => 'continued',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
