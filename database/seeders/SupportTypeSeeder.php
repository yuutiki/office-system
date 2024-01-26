<?php

namespace Database\Seeders;

use App\Models\SupportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTypeSeeder extends Seeder
{
    public function run(): void
    {
        SupportType::create([
            'type_code' => '10',
            'type_name' => '通常',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '20',
            'type_name' => '不具合（PKG）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '21',
            'type_name' => '不具合（CUS）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '22',
            'type_name' => '不具合（導入）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '23',
            'type_name' => '不具合（データ）',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '30',
            'type_name' => 'インフラ関連',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '40',
            'type_name' => '要望受付',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportType::create([
            'type_code' => '90',
            'type_name' => '備忘録',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
