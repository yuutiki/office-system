<?php

namespace Database\Seeders;

use App\Models\DistributionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistributionTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DistributionType::create([
            'distribution_type_code' => '10',
            'distribution_type_name' => '直販',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DistributionType::create([
            'distribution_type_code' => '20',
            'distribution_type_name' => 'ディーラ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}