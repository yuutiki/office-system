<?php

namespace Database\Seeders;

use App\Models\AccountingPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountingPeriodSeeder extends Seeder
{
    public function run(): void
    {
        AccountingPeriod::create([
            'period_name' => '40期',
            'period_start_at' => '20201101',
            'period_end_at' => '20211031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '41期',
            'period_start_at' => '20211101',
            'period_end_at' => '20221031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '42期',
            'period_start_at' => '20221101',
            'period_end_at' => '20231031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '43期',
            'period_start_at' => '20231101',
            'period_end_at' => '20241031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '44期',
            'period_start_at' => '20241101',
            'period_end_at' => '20251031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '45期',
            'period_start_at' => '20251101',
            'period_end_at' => '20261031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '46期',
            'period_start_at' => '20261101',
            'period_end_at' => '20271031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        AccountingPeriod::create([
            'period_name' => '47期',
            'period_start_at' => '20271101',
            'period_end_at' => '20281031',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
