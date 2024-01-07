<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TradeStatus;

class TradeStatusSeeder extends Seeder
{
    public function run(): void
    {
        TradeStatus::create([
            'trade_status_code' => '10',
            'trade_status_name' => 'ユーザ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        TradeStatus::create([
            'trade_status_code' => '20',
            'trade_status_name' => '新規：過去有',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        TradeStatus::create([
            'trade_status_code' => '30',
            'trade_status_name' => '新規：過去無',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
