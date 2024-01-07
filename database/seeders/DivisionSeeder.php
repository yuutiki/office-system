<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        Division::create([
            'division_code' => '10',
            'division_name' => '営業部',
            'division_kana_name' => 'エイギョウブ',
            'division_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Division::create([
            'division_code' => '11',
            'division_name' => '東日本営業部',
            'division_kana_name' => '',
            'division_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Division::create([
            'division_code' => '12',
            'division_name' => '開発部',
            'division_kana_name' => '',
            'division_eng_name' => '',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
