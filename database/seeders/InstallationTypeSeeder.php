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
            'name' => '国公立',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        InstallationType::create([
            'name' => '私立',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        InstallationType::create([
            'name' => 'その他',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
