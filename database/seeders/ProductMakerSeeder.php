<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductMaker;

class ProductMakerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ProductMaker::create([
            'maker_code' => 'SD',
            'maker_name' => 'システムディ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductMaker::create([
            'maker_code' => 'ZZ',
            'maker_name' => '他社',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}