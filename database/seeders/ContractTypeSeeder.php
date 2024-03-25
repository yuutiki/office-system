<?php

namespace Database\Seeders;

use App\Models\ContractType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    public function run(): void
    {
        ContractType::create([
            'contract_type_code' => '10',
            'contract_type_name' => 'サポート契約',
            'contract_type_name_en' => 'Support',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractType::create([
            'contract_type_code' => '20',
            'contract_type_name' => 'クラウドStandard',
            'contract_type_name_en' => 'Cloud Standard',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractType::create([
            'contract_type_code' => '30',
            'contract_type_name' => 'クラウドLitePlus',
            'contract_type_name_en' => 'Cloud LitePlus',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractType::create([
            'contract_type_code' => '40',
            'contract_type_name' => 'クラウドLite',
            'contract_type_name_en' => 'Cloud Lite',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractType::create([
            'contract_type_code' => '50',
            'contract_type_name' => 'バックアップサービス',
            'contract_type_name_en' => 'Backup',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
