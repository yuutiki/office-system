<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Affiliation2;

class Affiliation2Seeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Affiliation2::create([
            'affiliation2_code' => '11',
            'affiliation2_prefix' => 'C',
            'affiliation2_name' => '学園ソリューション事業部',
            'affiliation2_name_kana' => 'ガクエンソリューションジギョウブ',
            'affiliation2_name_en' => 'Gakuen',
            'affiliation2_name_short' => '学園',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation2::create([
            'affiliation2_code' => '12',
            'affiliation2_prefix' => 'S',
            'affiliation2_name' => 'ソフトエンジニアリング事業部',
            'affiliation2_name_kana' => 'ソフトエンジニアリングジギョウブ',
            'affiliation2_name_en' => 'SoftEngine',
            'affiliation2_name_short' => 'ソフト',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation2::create([
            'affiliation2_code' => '13',
            'affiliation2_prefix' => 'E',
            'affiliation2_name' => '公教育ソリューション事業部',
            'affiliation2_name_kana' => 'コウキョウイクソリューションジギョウブ',
            'affiliation2_name_en' => 'Koukyouiku',
            'affiliation2_name_short' => '公教育',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation2::create([
            'affiliation2_code' => '14',
            'affiliation2_prefix' => 'A',
            'affiliation2_name' => '公会計ソリューション事業部',
            'affiliation2_name_kana' => 'コウカイケイソリューションジギョウブ',
            'affiliation2_name_en' => 'Koukaikei',
            'affiliation2_name_short' => '公会計',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation2::create([
            'affiliation2_code' => '15',
            'affiliation2_prefix' => 'W',
            'affiliation2_name' => 'ウェルネスソリューション事業部',
            'affiliation2_name_kana' => 'ウェルネスソリューションジギョウブ',
            'affiliation2_name_en' => 'Wellness',
            'affiliation2_name_short' => 'ウェルネス',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Affiliation2::create([
            'affiliation2_code' => '90',
            'affiliation2_prefix' => 'M',
            'affiliation2_name' => '管理本部',
            'affiliation2_name_kana' => 'カンリホンブ',
            'affiliation2_name_en' => 'Manage',
            'affiliation2_name_short' => '管理部',
            'affiliation1_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}