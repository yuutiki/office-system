<?php

namespace Database\Seeders;

use App\Models\SupportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        SupportType::create([
            'code' => '10',
            'name' => '通常',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '20',
            'name' => '不具合（PKG）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '21',
            'name' => '不具合（CUS）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '22',
            'name' => '不具合（導入）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '23',
            'name' => '不具合（データ）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '30',
            'name' => 'インフラ関連',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '40',
            'name' => '要望受付',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'code' => '90',
            'name' => '備忘録',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}