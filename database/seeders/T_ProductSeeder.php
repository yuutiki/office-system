<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class T_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 必要なマスタデータを取得
        $makerIds = DB::table('product_makers')->pluck('id')->toArray();
        $affiliation2Ids = DB::table('affiliation2s')->pluck('id')->toArray();
        $departmentIds = DB::table('departments')->pluck('id')->toArray();
        $typeIds = DB::table('product_types')->pluck('id')->toArray();
        $splitTypeIds = DB::table('product_split_types')->pluck('id')->toArray();
        $seriesIds = DB::table('product_series')->pluck('id')->toArray();

        // データが存在しない場合の処理
        if (empty($makerIds) || empty($affiliation2Ids) || empty($departmentIds) || 
            empty($typeIds) || empty($splitTypeIds) || empty($seriesIds)) {
            $this->command->error('必要なマスタデータが不足しています。先にシードしてください。');
            return;
        }

        // 5件の製品データ
        $products = [
            [
                'product_code' => 'PRD-2025-0001',
                'product_maker_id' => $makerIds[array_rand($makerIds)],
                'affiliation2_id' => $affiliation2Ids[array_rand($affiliation2Ids)],
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'product_type_id' => $typeIds[array_rand($typeIds)],
                'product_split_type_id' => $splitTypeIds[array_rand($splitTypeIds)],
                'product_series_id' => $seriesIds[array_rand($seriesIds)],
                'unit_price' => 150000.00,
                'product_name' => 'クラウド会計システム Pro',
                'product_short_name' => 'クラウド会計Pro',
                'is_stop_selling' => false,
                'is_listed' => true,
                'product_memo1' => '中小企業向けクラウド会計システム。月次決算対応。',
                'product_memo2' => 'API連携可能。複数拠点対応。',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'PRD-2025-0002',
                'product_maker_id' => $makerIds[array_rand($makerIds)],
                'affiliation2_id' => $affiliation2Ids[array_rand($affiliation2Ids)],
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'product_type_id' => $typeIds[array_rand($typeIds)],
                'product_split_type_id' => $splitTypeIds[array_rand($splitTypeIds)],
                'product_series_id' => $seriesIds[array_rand($seriesIds)],
                'unit_price' => 250000.00,
                'product_name' => '販売管理システム Enterprise',
                'product_short_name' => '販売管理Ent',
                'is_stop_selling' => false,
                'is_listed' => true,
                'product_memo1' => '大企業向け販売管理システム。在庫管理機能付き。',
                'product_memo2' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'PRD-2025-0003',
                'product_maker_id' => $makerIds[array_rand($makerIds)],
                'affiliation2_id' => $affiliation2Ids[array_rand($affiliation2Ids)],
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'product_type_id' => $typeIds[array_rand($typeIds)],
                'product_split_type_id' => $splitTypeIds[array_rand($splitTypeIds)],
                'product_series_id' => $seriesIds[array_rand($seriesIds)],
                'unit_price' => 80000.00,
                'product_name' => '給与計算システム Lite',
                'product_short_name' => '給与計算Lt',
                'is_stop_selling' => false,
                'is_listed' => true,
                'product_memo1' => '小規模事業者向け給与計算システム。',
                'product_memo2' => '年末調整機能あり。',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'PRD-2025-0004',
                'product_maker_id' => $makerIds[array_rand($makerIds)],
                'affiliation2_id' => $affiliation2Ids[array_rand($affiliation2Ids)],
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'product_type_id' => $typeIds[array_rand($typeIds)],
                'product_split_type_id' => $splitTypeIds[array_rand($splitTypeIds)],
                'product_series_id' => $seriesIds[array_rand($seriesIds)],
                'unit_price' => 0.00,
                'product_name' => 'カスタマイズ開発',
                'product_short_name' => 'カスタム開発',
                'is_stop_selling' => false,
                'is_listed' => false,
                'product_memo1' => '個別カスタマイズ開発案件用。',
                'product_memo2' => '見積都度作成。',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'PRD-2024-9999',
                'product_maker_id' => $makerIds[array_rand($makerIds)],
                'affiliation2_id' => $affiliation2Ids[array_rand($affiliation2Ids)],
                'department_id' => $departmentIds[array_rand($departmentIds)],
                'product_type_id' => $typeIds[array_rand($typeIds)],
                'product_split_type_id' => $splitTypeIds[array_rand($splitTypeIds)],
                'product_series_id' => $seriesIds[array_rand($seriesIds)],
                'unit_price' => 120000.00,
                'product_name' => '旧バージョン会計システム',
                'product_short_name' => '旧会計システム',
                'is_stop_selling' => true,
                'is_listed' => false,
                'product_memo1' => '販売終了製品。サポートのみ継続中。',
                'product_memo2' => '2024年12月販売終了。',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);

        $this->command->info('5 products created successfully.');
    }
}