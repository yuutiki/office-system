<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InstallationType;

class InstallationTypeSeeder extends Seeder
{
    public function run(): void
    {
        InstallationType::create([
            'type_code' => '10',
            'type_name' => '国公立',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        InstallationType::create([
            'type_code' => '20',
            'type_name' => '私立',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        InstallationType::create([
            'type_code' => '90',
            'type_name' => 'その他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
