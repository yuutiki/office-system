<?php

namespace Database\Seeders;

use App\Models\ContractPartnerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractPartnerTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ContractPartnerType::create([
            'contract_partner_type_code' => '10',
            'contract_partner_type_name' => '顧客',
            'contract_partner_type_name_en' => 'Client',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractPartnerType::create([
            'contract_partner_type_code' => '20',
            'contract_partner_type_name' => 'ディーラ',
            'contract_partner_type_name_en' => 'Dealer',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContractPartnerType::create([
            'contract_partner_type_code' => '30',
            'contract_partner_type_name' => 'その他',
            'contract_partner_type_name_en' => 'Others',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}