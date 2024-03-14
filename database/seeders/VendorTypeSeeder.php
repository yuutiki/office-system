<?php

namespace Database\Seeders;

use App\Models\VendorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendorType::create([
            'vendor_type_code' => '10',
            'vendor_type_name' => '株式会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'vendor_type_code' => '11',
            'vendor_type_name' => '合同会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'vendor_type_code' => '12',
            'vendor_type_name' => '合名会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        VendorType::create([
            'vendor_type_code' => '13',
            'vendor_type_name' => '合資会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);


    }
}
