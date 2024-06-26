<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class T_ClientSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Client::create([
            'client_num' => '999990-C-C01',
            'client_name' => '札幌大谷学園',
            'client_kana_name' => 'サッポロオオタニガクエン',
            'affiliation2_id' => '1',
            'user_id' => '2',
            'installation_type_id' => '1',
            'client_type_id' => '1',
            'trade_status_id' => '1',
            'corporation_id' => '1',
            // 'head_post_code' => '',
            // 'head_prefecture' => '',
            // 'head_address1' => '',
            // 'head_tel' => '',
            // 'head_fax' => '',
            // 'students' => '',
            'memo' => '1494-01-28-00',
            // 'distribution' => '',
            // 'dealer_id' => '',
            'is_enduser' => '1',
            // 'is_supplier' => '',
            // 'is_dealer' => '',
            // 'is_lease' => '',
            // 'is_other_partner' => '',
            // 'is_closed' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Client::create([
            'client_num' => '999991-C-C01',
            'client_name' => '東洋女子高等学校',
            'client_kana_name' => 'トウヨウジョシコウトウガッコウ',
            'affiliation2_id' => '1',
            'user_id' => '2',
            'installation_type_id' => '1',
            'client_type_id' => '1',
            'trade_status_id' => '1',
            'corporation_id' => '2',
            // 'head_post_code' => '',
            // 'head_prefecture' => '',
            // 'head_address1' => '',
            // 'head_tel' => '',
            // 'head_fax' => '',
            // 'students' => '',
            'memo' => '1494-01-28-00',
            // 'distribution' => '',
            // 'dealer_id' => '',
            'is_enduser' => '1',
            // 'is_supplier' => '',
            // 'is_dealer' => '',
            // 'is_lease' => '',
            // 'is_other_partner' => '',
            // 'is_closed' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Client::create([
            'client_num' => '999992-C-C01',
            'client_name' => '聖路加国際大学',
            'client_kana_name' => 'セイロカコクサイダイガク',
            'affiliation2_id' => '1',
            'user_id' => '2',
            'installation_type_id' => '1',
            'client_type_id' => '1',
            'trade_status_id' => '1',
            'corporation_id' => '3',
            // 'head_post_code' => '',
            // 'head_prefecture' => '',
            // 'head_address1' => '',
            // 'head_tel' => '',
            // 'head_fax' => '',
            // 'students' => '',
            'memo' => '1494-01-28-00',
            // 'distribution' => '',
            // 'dealer_id' => '',
            'is_enduser' => '1',
            // 'is_supplier' => '',
            // 'is_dealer' => '',
            // 'is_lease' => '',
            // 'is_other_partner' => '',
            // 'is_closed' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Client::create([
            'client_num' => '999993-C-C01',
            'client_name' => '桐朋学園大学',
            'client_kana_name' => 'トウホウガクエンダイガク',
            'affiliation2_id' => '1',
            'user_id' => '2',
            'installation_type_id' => '1',
            'client_type_id' => '1',
            'trade_status_id' => '1',
            'corporation_id' => '4',
            // 'head_post_code' => '',
            // 'head_prefecture' => '',
            // 'head_address1' => '',
            // 'head_tel' => '',
            // 'head_fax' => '',
            // 'students' => '',
            'memo' => '0477-01-28-00',
            // 'distribution' => '',
            // 'dealer_id' => '',
            'is_enduser' => '1',
            // 'is_supplier' => '',
            // 'is_dealer' => '',
            // 'is_lease' => '',
            // 'is_other_partner' => '',
            // 'is_closed' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        Client::create([
            'client_num' => '999994-C-C01',
            'client_name' => '帝京平成大学',
            'client_kana_name' => 'テイキョウヘイセイダイガク',
            'affiliation2_id' => '1',
            'user_id' => '2',
            'installation_type_id' => '1',
            'client_type_id' => '1',
            'trade_status_id' => '1',
            'corporation_id' => '5',
            // 'head_post_code' => '',
            // 'head_prefecture' => '',
            // 'head_address1' => '',
            // 'head_tel' => '',
            // 'head_fax' => '',
            // 'students' => '',
            'memo' => '0477-01-28-00',
            // 'distribution' => '',
            // 'dealer_id' => '',
            'is_enduser' => '1',
            // 'is_supplier' => '',
            // 'is_dealer' => '',
            // 'is_lease' => '',
            // 'is_other_partner' => '',
            // 'is_closed' => '',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}