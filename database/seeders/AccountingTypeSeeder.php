<?php

namespace Database\Seeders;

use App\Models\AccountingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountingTypeSeeder extends Seeder
{
    public function run(): void
    {
        AccountingType::create([
            'accounting_type_code' => '10',
            'accounting_type_name' => '一括計上',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingType::create([
            'accounting_type_code' => '20',
            'accounting_type_name' => '分割計上',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
