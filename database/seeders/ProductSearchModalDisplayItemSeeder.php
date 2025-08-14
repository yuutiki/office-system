<?php

namespace Database\Seeders;

use App\Models\ProductSearchModalDisplayItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSearchModalDisplayItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductSearchModalDisplayItem::insert([
            [
                'screen_id' => 'order_entry',
                'column_key' => 'product_name',
                'display_default_name' => '製品名称',
                'display_name' => '製品名称',
                'display_order' => 1,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'order_entry',
                'column_key' => 'product_series.series_name',
                'display_default_name' => 'シリーズ',
                'display_name' => 'シリーズ',
                'display_order' => 2,
                'is_visible' => true,
            ],
        ]);
    }
}
