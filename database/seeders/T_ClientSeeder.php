<?php

// namespace Database\Seeders;

// use App\Models\Client;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

// class T_ClientSeeder extends Seeder
// {
//     use WithoutModelEvents;

//     public function run(): void
//     {
//         Client::create([
//             'client_num' => '999990-C-C01',
//             'client_name' => '札幌大谷学園',
//             'client_kana_name' => 'サッポロオオタニガクエン',
//             'affiliation2_id' => '1',
//             'user_id' => '2',
//             'installation_type_id' => '1',
//             'client_type_id' => '1',
//             'trade_status_id' => '1',
//             'corporation_id' => '1',
//             // 'head_post_code' => '',
//             // 'head_prefecture' => '',
//             // 'head_address1' => '',
//             // 'head_tel' => '',
//             // 'head_fax' => '',
//             // 'students' => '',
//             'memo' => '1494-01-28-00',
//             // 'distribution' => '',
//             // 'dealer_id' => '',
//             'is_enduser' => '1',
//             // 'is_supplier' => '',
//             // 'is_dealer' => '',
//             // 'is_lease' => '',
//             // 'is_other_partner' => '',
//             // 'is_closed' => '',
//             'created_by' => '1',
//             'updated_by' => '1',
//         ]);
//         Client::create([
//             'client_num' => '999991-C-C01',
//             'client_name' => '東洋女子高等学校',
//             'client_kana_name' => 'トウヨウジョシコウトウガッコウ',
//             'affiliation2_id' => '1',
//             'user_id' => '2',
//             'installation_type_id' => '1',
//             'client_type_id' => '1',
//             'trade_status_id' => '1',
//             'corporation_id' => '2',
//             // 'head_post_code' => '',
//             // 'head_prefecture' => '',
//             // 'head_address1' => '',
//             // 'head_tel' => '',
//             // 'head_fax' => '',
//             // 'students' => '',
//             'memo' => '1494-01-28-00',
//             // 'distribution' => '',
//             // 'dealer_id' => '',
//             'is_enduser' => '1',
//             // 'is_supplier' => '',
//             // 'is_dealer' => '',
//             // 'is_lease' => '',
//             // 'is_other_partner' => '',
//             // 'is_closed' => '',
//             'created_by' => '1',
//             'updated_by' => '1',
//         ]);
//         Client::create([
//             'client_num' => '999992-C-C01',
//             'client_name' => '聖路加国際大学',
//             'client_kana_name' => 'セイロカコクサイダイガク',
//             'affiliation2_id' => '1',
//             'user_id' => '2',
//             'installation_type_id' => '1',
//             'client_type_id' => '1',
//             'trade_status_id' => '1',
//             'corporation_id' => '3',
//             // 'head_post_code' => '',
//             // 'head_prefecture' => '',
//             // 'head_address1' => '',
//             // 'head_tel' => '',
//             // 'head_fax' => '',
//             // 'students' => '',
//             'memo' => '1494-01-28-00',
//             // 'distribution' => '',
//             // 'dealer_id' => '',
//             'is_enduser' => '1',
//             // 'is_supplier' => '',
//             // 'is_dealer' => '',
//             // 'is_lease' => '',
//             // 'is_other_partner' => '',
//             // 'is_closed' => '',
//             'created_by' => '1',
//             'updated_by' => '1',
//         ]);
//         Client::create([
//             'client_num' => '999993-C-C01',
//             'client_name' => '桐朋学園大学',
//             'client_kana_name' => 'トウホウガクエンダイガク',
//             'affiliation2_id' => '1',
//             'user_id' => '2',
//             'installation_type_id' => '1',
//             'client_type_id' => '1',
//             'trade_status_id' => '1',
//             'corporation_id' => '4',
//             // 'head_post_code' => '',
//             // 'head_prefecture' => '',
//             // 'head_address1' => '',
//             // 'head_tel' => '',
//             // 'head_fax' => '',
//             // 'students' => '',
//             'memo' => '0477-01-28-00',
//             // 'distribution' => '',
//             // 'dealer_id' => '',
//             'is_enduser' => '1',
//             // 'is_supplier' => '',
//             // 'is_dealer' => '',
//             // 'is_lease' => '',
//             // 'is_other_partner' => '',
//             // 'is_closed' => '',
//             'created_by' => '1',
//             'updated_by' => '1',
//         ]);
//         Client::create([
//             'client_num' => '999994-C-C01',
//             'client_name' => '帝京平成大学',
//             'client_kana_name' => 'テイキョウヘイセイダイガク',
//             'affiliation2_id' => '1',
//             'user_id' => '2',
//             'installation_type_id' => '1',
//             'client_type_id' => '1',
//             'trade_status_id' => '1',
//             'corporation_id' => '5',
//             // 'head_post_code' => '',
//             // 'head_prefecture' => '',
//             // 'head_address1' => '',
//             // 'head_tel' => '',
//             // 'head_fax' => '',
//             // 'students' => '',
//             'memo' => '0477-01-28-00',
//             // 'distribution' => '',
//             // 'dealer_id' => '',
//             'is_enduser' => '1',
//             // 'is_supplier' => '',
//             // 'is_dealer' => '',
//             // 'is_lease' => '',
//             // 'is_other_partner' => '',
//             // 'is_closed' => '',
//             'created_by' => '1',
//             'updated_by' => '1',
//         ]);
//     }
// }

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Corporation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_ClientSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $clientsData = [
            [
                'client_num' => '999990-C-C01',
                'client_name' => '札幌大谷学園',
                'client_kana_name' => 'サッポロオオタニガクエン',
                'corporation_name' => '学校法人 札幌大谷学園',
                'memo' => '1494-01-28-00',
            ],
            [
                'client_num' => '999991-C-C01',
                'client_name' => '東洋女子高等学校',
                'client_kana_name' => 'トウヨウジョシコウトウガッコウ',
                'corporation_name' => '学校法人 東洋女子学園',
                'memo' => '1494-01-28-00',
            ],
            [
                'client_num' => '999992-C-C01',
                'client_name' => '聖路加国際大学',
                'client_kana_name' => 'セイロカコクサイダイガク',
                'corporation_name' => '学校法人 聖路加国際大学',
                'memo' => '1494-01-28-00',
            ],
            [
                'client_num' => '999993-C-C01',
                'client_name' => '桐朋学園大学',
                'client_kana_name' => 'トウホウガクエンダイガク',
                'corporation_name' => '学校法人 桐朋学園',
                'memo' => '0477-01-28-00',
            ],
            [
                'client_num' => '999994-C-C01',
                'client_name' => '帝京平成大学',
                'client_kana_name' => 'テイキョウヘイセイダイガク',
                'corporation_name' => '学校法人 帝京平成大学',
                'memo' => '0477-01-28-00',
            ],
        ];

        foreach ($clientsData as $clientData) {
            $corporation = Corporation::firstOrCreate(
                ['corporation_name' => $clientData['corporation_name']],
                [
                    'corporation_num' => substr($clientData['client_num'], 0, 6),
                    'corporation_kana_name' => $clientData['client_kana_name'],
                    'corporation_short_name' => $clientData['client_name'],
                    'credit_limit' => 1000000,
                    'corporation_prefecture_id' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );

            Client::create([
                'client_num' => $clientData['client_num'],
                'client_name' => $clientData['client_name'],
                'client_kana_name' => $clientData['client_kana_name'],
                'affiliation2_id' => 1,
                'user_id' => 2,
                'installation_type_id' => 1,
                'client_type_id' => 1,
                'trade_status_id' => 1,
                'corporation_id' => $corporation->id,  // ULID
                'memo' => $clientData['memo'],
                'distribution' => '直販',
                'is_enduser' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
        // // 追加で994件のデータを生成（合計1000件になるように）
        // Corporation::factory()->count(994)->create();
    }
    
}