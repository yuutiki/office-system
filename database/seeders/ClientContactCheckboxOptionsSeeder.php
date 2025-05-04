<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientContactCheckboxOption;

class ClientContactCheckboxOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $defaultOptions = [
            // ['name' => 'is_billing_receiver', 'label' => '請求先', 'display_order' => 1],
            // ['name' => 'is_payment_receiver', 'label' => '支払先', 'display_order' => 2],
            ['name' => 'is_support_info_receiver', 'label' => 'サポート送付先', 'display_order' => 1],
            ['name' => 'is_closing_info_receiver', 'label' => '休業案内先', 'display_order' => 2],
            ['name' => 'is_exhibition_info_receiver', 'label' => '展示会案内先', 'display_order' => 3],
            ['name' => 'is_cloud_info_receiver', 'label' => 'クラウド案内先', 'display_order' => 4],
        ];
        
        foreach ($defaultOptions as $option) {
            ClientContactCheckboxOption::create([
                'name' => $option['name'],
                'label' => $option['label'],
                'display_order' => $option['display_order'],
            ]);
        }
    }
}
