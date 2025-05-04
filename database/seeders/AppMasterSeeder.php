<?php

namespace Database\Seeders;

use App\Models\AppMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppMasterSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        AppMaster::create([
            'master_type' => '共通マスタ',
            'master_code' => '900',
            'master_name' => '都道府県',
            'master_name_en' => 'ProductMaker',
            'route' => 'prefecture.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '共通マスタ',
            'master_code' => '990',
            'master_name' => '所属別リンク',
            'master_name_en' => 'Links by affiliation',
            'route' => 'link.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'ユーザマスタ',
            'master_code' => '100',
            'master_name' => '所属-階層1',
            'master_name_en' => 'ClientType',
            'route' => 'affiliation1.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'ユーザマスタ',
            'master_code' => '101',
            'master_name' => '所属-階層2',
            'master_name_en' => 'ClientType',
            'route' => 'affiliation2.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'ユーザマスタ',
            'master_code' => '102',
            'master_name' => '所属-階層3',
            'master_name_en' => 'ClientType',
            'route' => 'affiliation3.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '顧客マスタ',
            'master_code' => '110',
            'master_name' => '顧客種別',
            'master_name_en' => 'ClientType',
            'route' => 'client-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '顧客マスタ',
            'master_code' => '111',
            'master_name' => '設置種別',
            'master_name_en' => 'InstallationType',
            'route' => 'installation-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '顧客マスタ',
            'master_code' => '112',
            'master_name' => '取引状態',
            'master_name_en' => 'TradeStatus',
            'route' => 'trade-status.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '顧客マスタ',
            'master_code' => '113',
            'master_name' => '商流種別',
            'master_name_en' => 'DistributionType',
            'route' => 'distribution-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // AppMaster::create([
        //     'master_type' => '業者マスタ',
        //     'master_code' => '120',
        //     'master_name' => '業者種別',
        //     'master_name_en' => 'ProductMaker',
        //     'route' => 'vendor-type.index',
        //     'created_by' => 1,
        //     'updated_by' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '130',
            'master_name' => '製品種別',
            'master_name_en' => 'ProductType',
            'route' => 'product-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '131',
            'master_name' => '製品内訳種別',
            'master_name_en' => 'ProductSplitType',
            'route' => 'product-split-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '132',
            'master_name' => '製品カテゴリ',
            'master_name_en' => 'ProductCategory',
            'route' => 'product-category.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '133',
            'master_name' => '製品メーカ',
            'master_name_en' => 'ProductMaker',
            'route' => 'product-maker.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '134',
            'master_name' => '製品シリーズ',
            'master_name_en' => 'ProductMaker',
            'route' => 'product-series.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '製品マスタ',
            'master_code' => '135',
            'master_name' => '製品バージョン',
            'master_name_en' => 'ProductMaker',
            'route' => 'product-version.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'プロジェクトマスタ',
            'master_code' => '140',
            'master_name' => 'プロジェクト種別',
            'master_name_en' => 'ProductMaker',
            'route' => 'project-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'プロジェクトマスタ',
            'master_code' => '141',
            'master_name' => '営業段階',
            'master_name_en' => 'ProductMaker',
            'route' => 'sales-stage.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'プロジェクトマスタ',
            'master_code' => '142',
            'master_name' => '計上種別',
            'master_name_en' => 'ProductMaker',
            'route' => 'accounting-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'プロジェクトマスタ',
            'master_code' => '143',
            'master_name' => '計上期',
            'master_name_en' => 'ProductMaker',
            'route' => 'accounting-period.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'サポートマスタ',
            'master_code' => '150',
            'master_name' => 'サポート時間',
            'master_name_en' => 'ProductMaker',
            'route' => 'support-time.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => 'サポートマスタ',
            'master_code' => '151',
            'master_name' => 'サポート種別',
            'master_name_en' => 'ProductMaker',
            'route' => 'support-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '営業報告マスタ',
            'master_code' => '160',
            'master_name' => '営業報告種別',
            'master_name_en' => 'ProductMaker',
            'route' => 'report-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '営業報告マスタ',
            'master_code' => '161',
            'master_name' => '対応種別',
            'master_name_en' => 'ProductMaker',
            'route' => 'contact-type.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '見積マスタ',
            'master_code' => '170',
            'master_name' => '見積書住所',
            'master_name_en' => 'estimateAddress',
            'route' => 'estimate-address.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        AppMaster::create([
            'master_type' => '顧客担当者マスタ',
            'master_code' => '180',
            'master_name' => '顧客担当者チェックボックス',
            'master_name_en' => 'clientContactCheckbox',
            'route' => 'client-contacts.checkbox-options.index',
            'digit' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}