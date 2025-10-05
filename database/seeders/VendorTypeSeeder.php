<?php

namespace Database\Seeders;

use App\Models\VendorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        VendorType::create([
            'code' => '10',
            'name' => '株式会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'code' => '11',
            'name' => '合同会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'code' => '12',
            'name' => '合名会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'code' => '13',
            'name' => '合資会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}