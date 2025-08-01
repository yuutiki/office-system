<?php

namespace Database\Seeders;

use App\Models\Affiliation1;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Affiliation1Seeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::listen(function ($query) {
            Log::info('SQL', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ]);
        });

        Affiliation1::create([
            'affiliation1_code' => '10',
            'affiliation1_prefix' => 'S',
            'affiliation1_name' => '株式会社オーフィス',
            'affiliation1_kana_name' => 'カブシキガイシャオーフィス',
            'affiliation1_eng_name' => 'Orpfice,inc',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}