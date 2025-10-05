<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Vendor;

class T_VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DBからcorporationを取得
        $corporation = DB::table('corporations')->first();
        $departmentIds = DB::table('affiliation2s')->pluck('id')->toArray();

        // データが存在しない場合の処理
        if (empty($corporation) || empty($departmentIds)) {
            $this->command->error('CorporationsまたはAffiliation2テーブルにデータがありません。先にシードしてください。');
            return;
        }

        // 5件のベンダーデータ
        $vendorData = [
            [
                'vendor_name' => '株式会社山田商事',
                'vendor_kana_name' => 'カブシキガイシャヤマダショウジ',
                'vendor_type_id' => 1,
                'vendor_memo' => '主要取引先。月次発注あり。',
                'post_code' => '100-0001',
                'prefecture_id' => '13',
                'address_1' => '千代田区千代田1-1-1',
                'vendor_tel' => '03-1234-5678',
                'vendor_fax' => '03-1234-5679',
                'number_of_employees' => 150,
                'vendor_url' => 'https://www.yamada-shoji.co.jp',
                'is_supplier' => true,
                'is_dealer' => false,
                'is_lease' => false,
                'is_other_partner' => false,
                'bank_code' => '0001',
                'bank_name' => 'みずほ銀行',
                'branch_code' => '001',
                'branch_name' => '東京営業部',
                'account_type' => '0',
                'account_number' => '1234567',
                'account_name' => 'カ)ヤマダショウジ',
            ],
            [
                'vendor_name' => '佐藤建設株式会社',
                'vendor_kana_name' => 'サトウケンセツカブシキガイシャ',
                'vendor_type_id' => 2,
                'vendor_memo' => '建設関連の外注先。',
                'post_code' => '530-0001',
                'prefecture_id' => '27',
                'address_1' => '大阪市北区梅田1-2-3',
                'vendor_tel' => '06-2345-6789',
                'vendor_fax' => '06-2345-6780',
                'number_of_employees' => 80,
                'vendor_url' => 'https://www.sato-kensetsu.co.jp',
                'is_supplier' => true,
                'is_dealer' => false,
                'is_lease' => false,
                'is_other_partner' => false,
                'bank_code' => '0005',
                'bank_name' => '三菱UFJ銀行',
                'branch_code' => '102',
                'branch_name' => '梅田支店',
                'account_type' => '0',
                'account_number' => '2345678',
                'account_name' => 'サトウケンセツ(カ',
            ],
            [
                'vendor_name' => '鈴木自動車販売株式会社',
                'vendor_kana_name' => 'スズキジドウシャハンバイカブシキガイシャ',
                'vendor_type_id' => 3,
                'vendor_memo' => null,
                'post_code' => '231-0001',
                'prefecture_id' => '14',
                'address_1' => '横浜市中区山下町1-1',
                'vendor_tel' => '045-3456-7890',
                'vendor_fax' => '045-3456-7891',
                'number_of_employees' => 45,
                'vendor_url' => null,
                'is_supplier' => false,
                'is_dealer' => true,
                'is_lease' => false,
                'is_other_partner' => false,
                'bank_code' => '0009',
                'bank_name' => '三井住友銀行',
                'branch_code' => '205',
                'branch_name' => '横浜支店',
                'account_type' => '1',
                'account_number' => '3456789',
                'account_name' => 'スズキジドウシャハンバイ(カ',
            ],
            [
                'vendor_name' => '東京リース株式会社',
                'vendor_kana_name' => 'トウキョウリースカブシキガイシャ',
                'vendor_type_id' => 4,
                'vendor_memo' => 'OA機器リース契約中。',
                'post_code' => '105-0001',
                'prefecture_id' => '13',
                'address_1' => '港区虎ノ門2-3-4',
                'vendor_tel' => '03-4567-8901',
                'vendor_fax' => '03-4567-8902',
                'number_of_employees' => 200,
                'vendor_url' => 'https://www.tokyo-lease.co.jp',
                'is_supplier' => false,
                'is_dealer' => false,
                'is_lease' => true,
                'is_other_partner' => false,
                'bank_code' => '0001',
                'bank_name' => 'みずほ銀行',
                'branch_code' => '015',
                'branch_name' => '虎ノ門支店',
                'account_type' => '0',
                'account_number' => '4567890',
                'account_name' => 'トウキョウリース(カ',
            ],
            [
                'vendor_name' => '田中物流株式会社',
                'vendor_kana_name' => 'タナカブツリュウカブシキガイシャ',
                'vendor_type_id' => null,
                'vendor_memo' => '配送業務委託先。',
                'post_code' => '460-0001',
                'prefecture_id' => '23',
                'address_1' => '名古屋市中区栄3-4-5',
                'vendor_tel' => '052-5678-9012',
                'vendor_fax' => null,
                'number_of_employees' => 120,
                'vendor_url' => null,
                'is_supplier' => false,
                'is_dealer' => false,
                'is_lease' => false,
                'is_other_partner' => true,
                'bank_code' => '0005',
                'bank_name' => '三菱UFJ銀行',
                'branch_code' => '301',
                'branch_name' => '名古屋営業部',
                'account_type' => '0',
                'account_number' => '5678901',
                'account_name' => 'タナカブツリュウ(カ',
            ],
        ];

        // 5件のベンダーを作成
        foreach ($vendorData as $data) {
            // vendor_numを生成（毎回最新の連番を取得）
            $vendorNum = $this->generateVendorNumber($corporation->corporation_num);

            $vendor = array_merge($data, [
                'ulid' => (string) Str::ulid(),
                'vendor_num' => $vendorNum,
                'corporation_id' => $corporation->id,
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('vendors')->insert($vendor);

            $this->command->info("Vendor created: {$vendorNum} - {$data['vendor_name']}");
        }
    }

    /**
     * vendor_numを生成
     */
    private function generateVendorNumber($corporationNum)
    {
        $lastVendor = DB::table('vendors')
            ->where('vendor_num', 'like', "$corporationNum-V-%")
            ->orderBy('vendor_num', 'desc')
            ->first();

        if ($lastVendor) {
            $lastSerialNumber = (int) Str::substr($lastVendor->vendor_num, -3);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '001';
        }

        return "$corporationNum-V-$newSerialNumber";
    }
}