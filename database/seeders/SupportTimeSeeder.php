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
            'code' => '10',
            'name' => '5分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '15',
            'name' => '10分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '20',
            'name' => '20分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '25',
            'name' => '30分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '30',
            'name' => '60分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '35',
            'name' => '180分程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '40',
            'name' => '半日程度',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '45',
            'name' => '1日間',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '50',
            'name' => '2日間',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '55',
            'name' => '3日間以上',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SupportTime::create([
            'code' => '60',
            'name' => '1週間以上',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}