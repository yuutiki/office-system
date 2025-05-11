<?php

namespace Database\Seeders;

use App\Models\CorporationSearchModalDisplayItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporationSearchModalDisplayItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CorporationSearchModalDisplayItem::insert([
            [
                'screen_id' => 'order_entry',
                'column_key' => 'corporation_name',
                'display_default_name' => '法人名称',
                'display_name' => '法人名称',
                'display_order' => 1,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'order_entry',
                'column_key' => 'corporation_num',
                'display_default_name' => '法人No.',
                'display_name' => '法人No.',
                'display_order' => 2,
                'is_visible' => true,
            ],
        ]);
    }
}
