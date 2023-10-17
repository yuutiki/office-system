<?php

namespace Database\Seeders;

use App\Models\SalesStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesStageSeeder extends Seeder
{
    public function run(): void
    {
        SalesStage::create([
            'sales_stage_code' => '10',
            'sales_stage_name' => '営業中',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SalesStage::create([
            'sales_stage_code' => '20',
            'sales_stage_name' => '商談中',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SalesStage::create([
            'sales_stage_code' => '30',
            'sales_stage_name' => '見込有',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SalesStage::create([
            'sales_stage_code' => '40',
            'sales_stage_name' => '受注（契約）',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SalesStage::create([
            'sales_stage_code' => '50',
            'sales_stage_name' => '計上',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SalesStage::create([
            'sales_stage_code' => '90',
            'sales_stage_name' => 'ボツ',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
