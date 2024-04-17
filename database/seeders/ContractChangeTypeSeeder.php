<?php

namespace Database\Seeders;

use App\Models\ContractChangeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractChangeTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ContractChangeType::create([
            'contract_change_type_code' => '10',
            'contract_change_type_name' => '新規',
            'contract_change_type_name_en' => 'New',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractChangeType::create([
            'contract_change_type_code' => '20',
            'contract_change_type_name' => '更新',
            'contract_change_type_name_en' => 'Continue',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractChangeType::create([
            'contract_change_type_code' => '30',
            'contract_change_type_name' => '変更',
            'contract_change_type_name_en' => 'Change',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}