<?php

namespace Database\Seeders;

use App\Models\ClientSearchModalDisplayItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSearchModalDisplayItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientSearchModalDisplayItem::insert([
            [
                'screen_id' => 'order_entry',
                'column_key' => 'client_name',
                'display_default_name' => '顧客名称',
                'display_name' => '顧客名称',
                'display_order' => 1,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'order_entry',
                'column_key' => 'client_num',
                'display_default_name' => '顧客No.',
                'display_name' => '顧客No.',
                'display_order' => 2,
                'is_visible' => true,
            ],
            [
                'screen_id' => 'order_entry',
                'column_key' => 'user.user_name',
                'display_default_name' => '営業担当',
                'display_name' => '営業担当',
                'display_order' => 3,
                'is_visible' => true,
            ],
        ]);
    }
}
