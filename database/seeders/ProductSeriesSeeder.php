<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductSeries;

class ProductSeriesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ProductSeries::create([
            'series_code' => '10',
            'series_name' => 'CP.Net',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSeries::create([
            'series_code' => '11',
            'series_name' => 'CPSmart',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSeries::create([
            'series_code' => '99',
            'series_name' => '共通',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // ProductSeries::create([
        //     'series_code' => '03',
        //     'series_name' => 'CPWindows',
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        // ProductSeries::create([
        //     'series_code' => '04',
        //     'series_name' => 'CPDos',
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
    }
}