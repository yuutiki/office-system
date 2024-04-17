<?php

namespace Database\Seeders;

use App\Models\SupportTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTimeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        SupportTime::create([
            'time_code' => '10',
            'time_name' => '5分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '15',
            'time_name' => '10分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '20',
            'time_name' => '20分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '25',
            'time_name' => '30分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '30',
            'time_name' => '60分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '35',
            'time_name' => '180分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '40',
            'time_name' => '半日程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '45',
            'time_name' => '1日間',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '50',
            'time_name' => '2日間',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '55',
            'time_name' => '3日間以上',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '60',
            'time_name' => '1週間以上',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}