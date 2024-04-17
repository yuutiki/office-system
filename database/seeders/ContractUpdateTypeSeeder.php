<?php

namespace Database\Seeders;

use App\Models\ContractUpdateType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractUpdateTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ContractUpdateType::create([
            'contract_update_type_code' => '10',
            'contract_update_type_name' => '自動更新',
            'contract_update_type_name_en' => 'Auto',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractUpdateType::create([
            'contract_update_type_code' => '20',
            'contract_update_type_name' => '都度契約',
            'contract_update_type_name_en' => 'Self',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}