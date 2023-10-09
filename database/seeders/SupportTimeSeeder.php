<?php

namespace Database\Seeders;

use App\Models\SupportTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTimeSeeder extends Seeder
{
    public function run(): void
    {
        SupportTime::create([
            'time_code' => '07',
            'time_name' => '5分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '08',
            'time_name' => '10分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '09',
            'time_name' => '20分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '10',
            'time_name' => '30分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '11',
            'time_name' => '60分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '12',
            'time_name' => '180分程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '13',
            'time_name' => '半日程度',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '14',
            'time_name' => '1日間',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '15',
            'time_name' => '2日間',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '16',
            'time_name' => '3日間以上',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'time_code' => '17',
            'time_name' => '1週間以上',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
