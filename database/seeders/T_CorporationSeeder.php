<?php

namespace Database\Seeders;

use App\Models\Corporation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_CorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Corporation::create([
            'corporation_num' => '999990',
            'corporation_name' => '学校法人 札幌大谷学園',
            'corporation_kana_name' => 'ガッコウホウジン サッポロオオタニガクエン',
            'corporation_short_name' => '札幌大谷学園',
            'credit_limit' => '1000000',
            // 'corporation_memo' => '',
            // 'corporation_post_code' => '',
            // 'corporation_prefecture_id' => '',
            // 'corporation_address1' => '',
            // 'is_stop_trading' => '',
            // 'stop_trading_reason' => '',
            // 'invoice_num' => '',
            // 'invoice_at' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Corporation::create([
            'corporation_num' => '999991',
            'corporation_name' => '学校法人 東洋女子学園',
            'corporation_kana_name' => 'ガッコウホウジン トウヨウジョシガクエン',
            'corporation_short_name' => '東洋女子学園',
            'credit_limit' => '1000000',
            // 'corporation_memo' => '',
            // 'corporation_post_code' => '',
            // 'corporation_prefecture_id' => '',
            // 'corporation_address1' => '',
            // 'is_stop_trading' => '',
            // 'stop_trading_reason' => '',
            // 'invoice_num' => '',
            // 'invoice_at' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Corporation::create([
            'corporation_num' => '999992',
            'corporation_name' => '学校法人 聖路加国際大学',
            'corporation_kana_name' => 'ガッコウホウジン セイロカコクサイダイガク',
            'corporation_short_name' => '聖路加国際大学',
            'credit_limit' => '1000000',
            // 'corporation_memo' => '',
            // 'corporation_post_code' => '',
            // 'corporation_prefecture_id' => '',
            // 'corporation_address1' => '',
            // 'is_stop_trading' => '',
            // 'stop_trading_reason' => '',
            // 'invoice_num' => '',
            // 'invoice_at' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Corporation::create([
            'corporation_num' => '999993',
            'corporation_name' => '学校法人 桐朋学園',
            'corporation_kana_name' => 'ガッコウホウジン トウホウガクエン',
            'corporation_short_name' => '桐朋学園',
            'credit_limit' => '1000000',
            // 'corporation_memo' => '',
            // 'corporation_post_code' => '',
            // 'corporation_prefecture_id' => '',
            // 'corporation_address1' => '',
            // 'is_stop_trading' => '',
            // 'stop_trading_reason' => '',
            // 'invoice_num' => '',
            // 'invoice_at' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}


