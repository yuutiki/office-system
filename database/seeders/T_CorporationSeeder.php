<?php

namespace Database\Seeders;

use App\Models\Corporation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_CorporationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // イベントを一時的に無効化して、created_byとupdated_byを手動で設定
        // Corporation::withoutEvents(function () {
        //     Corporation::create([
        //         'corporation_num' => '999990',
        //         'corporation_name' => '学校法人 札幌大谷学園',
        //         'corporation_kana_name' => 'ガッコウホウジン サッポロオオタニガクエン',
        //         'corporation_short_name' => '札幌大谷学園',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         // 'corporation_post_code' => '',
        //         'corporation_prefecture_id' => '1',
        //         // 'corporation_address1' => '',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         // 'invoice_num' => '',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        //     Corporation::create([
        //         'corporation_num' => '999991',
        //         'corporation_name' => '学校法人 東洋女子学園',
        //         'corporation_kana_name' => 'ガッコウホウジン トウヨウジョシガクエン',
        //         'corporation_short_name' => '東洋女子学園',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         // 'corporation_post_code' => '',
        //         'corporation_prefecture_id' => '13',
        //         // 'corporation_address1' => '',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         // 'invoice_num' => '',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        //     Corporation::create([
        //         'corporation_num' => '999992',
        //         'corporation_name' => '学校法人 聖路加国際大学',
        //         'corporation_kana_name' => 'ガッコウホウジン セイロカコクサイダイガク',
        //         'corporation_short_name' => '聖路加国際大学',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         // 'corporation_post_code' => '',
        //         'corporation_prefecture_id' => '13',
        //         // 'corporation_address1' => '',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         // 'invoice_num' => '',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        //     Corporation::create([
        //         'corporation_num' => '999993',
        //         'corporation_name' => '学校法人 桐朋学園',
        //         'corporation_kana_name' => 'ガッコウホウジン トウホウガクエン',
        //         'corporation_short_name' => '桐朋学園',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         // 'corporation_post_code' => '',
        //         'corporation_prefecture_id' => '13',
        //         // 'corporation_address1' => '',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         // 'invoice_num' => '',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        //     Corporation::create([
        //         'corporation_num' => '999994',
        //         'corporation_name' => '学校法人 帝京平成大学',
        //         'corporation_kana_name' => 'ガッコウホウジン テイキョウヘイセイダイガク',
        //         'corporation_short_name' => '帝京平成大学',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         // 'corporation_post_code' => '',
        //         'corporation_prefecture_id' => '13',
        //         // 'corporation_address1' => '',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         // 'invoice_num' => '',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        //     Corporation::create([
        //         'corporation_num' => '999995',
        //         'corporation_name' => '学校法人 札幌学院大学',
        //         'corporation_kana_name' => 'ガッコウホウジン サッポロガクインダイガク',
        //         'corporation_short_name' => '札幌学院大学',
        //         'credit_limit' => '1000000',
        //         // 'corporation_memo' => '',
        //         'corporation_post_code' => '069-8555',
        //         'corporation_prefecture_id' => '1',
        //         'corporation_address1' => '江別市文京台11番地',
        //         // 'is_stop_trading' => '',
        //         // 'stop_trading_reason' => '',
        //         'invoice_num' => 'T7430005005589',
        //         // 'invoice_at' => '',
        //         'created_by' => '1',
        //         'updated_by' => '1',
        //     ]);
        // });



        // 既存のデータを保持
        $existingCorporations = [
            [
                'corporation_num' => '999990',
                'corporation_name' => '学校法人 札幌大谷学園',
                'corporation_kana_name' => 'ガッコウホウジン サッポロオオタニガクエン',
                'corporation_short_name' => '札幌大谷学園',
                'credit_limit' => '1000000',
                'corporation_prefecture_id' => '1',
                'created_by' => '1',
                'updated_by' => '1',
            ],            [
                'corporation_num' => '999990',
                'corporation_name' => '学校法人 札幌大谷学園',
                'corporation_kana_name' => 'ガッコウホウジン サッポロオオタニガクエン',
                'corporation_short_name' => '札幌大谷学園',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                // 'corporation_post_code' => '',
                'corporation_prefecture_id' => '1',
                // 'corporation_address1' => '',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                // 'invoice_num' => '',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'corporation_num' => '999991',
                'corporation_name' => '学校法人 東洋女子学園',
                'corporation_kana_name' => 'ガッコウホウジン トウヨウジョシガクエン',
                'corporation_short_name' => '東洋女子学園',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                // 'corporation_post_code' => '',
                'corporation_prefecture_id' => '13',
                // 'corporation_address1' => '',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                // 'invoice_num' => '',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'corporation_num' => '999992',
                'corporation_name' => '学校法人 聖路加国際大学',
                'corporation_kana_name' => 'ガッコウホウジン セイロカコクサイダイガク',
                'corporation_short_name' => '聖路加国際大学',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                // 'corporation_post_code' => '',
                'corporation_prefecture_id' => '13',
                // 'corporation_address1' => '',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                // 'invoice_num' => '',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'corporation_num' => '999993',
                'corporation_name' => '学校法人 桐朋学園',
                'corporation_kana_name' => 'ガッコウホウジン トウホウガクエン',
                'corporation_short_name' => '桐朋学園',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                // 'corporation_post_code' => '',
                'corporation_prefecture_id' => '13',
                // 'corporation_address1' => '',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                // 'invoice_num' => '',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'corporation_num' => '999994',
                'corporation_name' => '学校法人 帝京平成大学',
                'corporation_kana_name' => 'ガッコウホウジン テイキョウヘイセイダイガク',
                'corporation_short_name' => '帝京平成大学',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                // 'corporation_post_code' => '',
                'corporation_prefecture_id' => '13',
                // 'corporation_address1' => '',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                // 'invoice_num' => '',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ],
            [
                'corporation_num' => '999995',
                'corporation_name' => '学校法人 札幌学院大学',
                'corporation_kana_name' => 'ガッコウホウジン サッポロガクインダイガク',
                'corporation_short_name' => '札幌学院大学',
                'credit_limit' => '1000000',
                // 'corporation_memo' => '',
                'corporation_post_code' => '069-8555',
                'corporation_prefecture_id' => '1',
                'corporation_address1' => '江別市文京台11番地',
                // 'is_stop_trading' => '',
                // 'stop_trading_reason' => '',
                'invoice_num' => 'T7430005005589',
                // 'invoice_at' => '',
                'created_by' => '1',
                'updated_by' => '1',
            ]
            // ... 他の既存のデータ ...
        ];

        // // イベントを一時的に無効化
        // Corporation::withoutEvents(function () use ($existingCorporations) {
        //     // 既存のデータを作成
        //     foreach ($existingCorporations as $corp) {
        //         Corporation::create($corp);
        //     }

        //     // 追加で994件のデータを生成（合計1000件になるように）
        //     Corporation::factory()->count(994)->create();
        // });
    }
}