<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    public function run(): void
    {
        ContactType::create([
            'contact_type_code' => '10',
            'contact_type_name' => 'オンライン',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '11',
            'contact_type_name' => '現地対応',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '12',
            'contact_type_name' => '来社対応',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '13',
            'contact_type_name' => '電話対応',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '14',
            'contact_type_name' => 'メール対応',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '15',
            'contact_type_name' => '資料送付',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ContactType::create([
            'contact_type_code' => '16',
            'contact_type_name' => 'その他',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
