<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientType;

class ClientTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ClientType::create([
            'client_type_code' => '10',
            'client_type_name' => '法人',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ClientType::create([
            'client_type_code' => '15',
            'client_type_name' => '大学',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ClientType::create([
            'client_type_code' => '20',
            'client_type_name' => '大学院大学',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '25',
            'client_type_name' => '専門職大学',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '30',
            'client_type_name' => '短期大学',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '35',
            'client_type_name' => '専門学校',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '40',
            'client_type_name' => '大学校',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '45',
            'client_type_name' => '省庁大学校',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '50',
            'client_type_name' => '中高',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '55',
            'client_type_name' => '高校',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '60',
            'client_type_name' => '中学',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '65',
            'client_type_name' => '幼稚園',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '80',
            'client_type_name' => '株式会社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ClientType::create([
            'client_type_code' => '90',
            'client_type_name' => 'その他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}