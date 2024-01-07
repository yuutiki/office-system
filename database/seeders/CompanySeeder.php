<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'company_code' => '10',
            'company_name' => '株式会社システムディ',
            'company_kana_name' => 'カブシキガイシャシステムディ',
            'company_eng_name' => 'SystemD,inc',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
