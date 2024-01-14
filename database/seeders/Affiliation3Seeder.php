<?php

namespace Database\Seeders;

use App\Models\Affiliation3;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Affiliation3Seeder extends Seeder
{
    public function run(): void
    {
        Affiliation3::create([
            'affiliation3_code' => '10',
            'affiliation3_prefix' => '1',
            'affiliation3_name' => '営業部',
            'affiliation3_name_kana' => 'エイギョウブ',
            'affiliation3_name_en' => '',
            'affiliation2_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation3::create([
            'affiliation3_code' => '11',
            'affiliation3_prefix' => '2',
            'affiliation3_name' => '東日本営業部',
            'affiliation3_name_kana' => 'ヒガシニホンエイギョウブ',
            'affiliation3_name_en' => '',
            'affiliation2_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation3::create([
            'affiliation3_code' => '12',
            'affiliation3_prefix' => '3',
            'affiliation3_name' => '開発部',
            'affiliation3_name_kana' => 'カイハツブ',
            'affiliation3_name_en' => '',
            'affiliation2_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}






