<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVersion;

class ProductVersionSeeder extends Seeder
{
    public function run(): void
    {
        ProductVersion::create([
            'version_code' => '0100',
            'version_name' => 'V1.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0200',
            'version_name' => 'V2.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0300',
            'version_name' => 'V3.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0400',
            'version_name' => 'V4.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0500',
            'version_name' => 'V5.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0501',
            'version_name' => 'V5.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0600',
            'version_name' => 'V6.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0601',
            'version_name' => 'V6.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0700',
            'version_name' => 'V7.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0701',
            'version_name' => 'V7.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0750',
            'version_name' => 'V7.5',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0751',
            'version_name' => 'V7.5sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0800',
            'version_name' => 'V8.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0801',
            'version_name' => 'V8.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0900',
            'version_name' => 'V9.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '0901',
            'version_name' => 'V9.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '1000',
            'version_name' => 'V10.0',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '1001',
            'version_name' => 'V10.0sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '1010',
            'version_name' => 'V10.1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '1020',
            'version_name' => 'V10.2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductVersion::create([
            'version_code' => '1021',
            'version_name' => 'V10.2sp1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
