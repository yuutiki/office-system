<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientType;

class ClientTypeSeeder extends Seeder
{
    public function run(): void
    {
        ClientType::create([
            'name' => '法人',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ClientType::create([
            'name' => '大学',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ClientType::create([
            'name' => '大学院大学',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '専門職大学',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '短期大学',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '専門学校',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '大学校',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '省庁大学校',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '中高',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '高校',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '中学',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => '幼稚園',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'name' => 'その他',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
