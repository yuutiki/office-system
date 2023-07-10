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
            'name' => 'ユーザ',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        TradeStatus::create([
            'name' => '新規：過去有',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        TradeStatus::create([
            'name' => '新規：過去無',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
