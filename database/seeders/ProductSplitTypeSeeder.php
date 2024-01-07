<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductSplitType;

class ProductSplitTypeSeeder extends Seeder
{
    public function run(): void
    {
        ProductSplitType::create([
            'product_type_id' => '1',
            'split_type_code' => '1000',
            'split_type_name' => 'パッケージ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '1',
            'split_type_code' => '1010',
            'split_type_name' => 'VersionUp',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '1',
            'split_type_code' => '1020',
            'split_type_name' => 'ライセンス',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '1',
            'split_type_code' => '1030',
            'split_type_name' => 'レンタル販売',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '2',
            'split_type_code' => '1100',
            'split_type_name' => 'カスタマイズ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '2',
            'split_type_code' => '1110',
            'split_type_name' => 'コンバート',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '3',
            'split_type_code' => '1200',
            'split_type_name' => '導入支援',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '3',
            'split_type_code' => '1210',
            'split_type_name' => '操作説明',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '3',
            'split_type_code' => '1220',
            'split_type_name' => '初期設定',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '4',
            'split_type_code' => '1300',
            'split_type_name' => 'サポート',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '4',
            'split_type_code' => '1310',
            'split_type_name' => 'アプリ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '4',
            'split_type_code' => '1390',
            'split_type_name' => 'サポートその他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '5',
            'split_type_code' => '1400',
            'split_type_name' => 'Cloud Lite',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '5',
            'split_type_code' => '1410',
            'split_type_name' => 'Cloud Lite Plus',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '5',
            'split_type_code' => '1420',
            'split_type_name' => 'Cloud Standard',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '5',
            'split_type_code' => '1430',
            'split_type_name' => 'バックアップ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '5',
            'split_type_code' => '1490',
            'split_type_name' => 'クラウドその他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '6',
            'split_type_code' => '1500',
            'split_type_name' => 'ハード',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '6',
            'split_type_code' => '1510',
            'split_type_name' => 'ソフト',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '7',
            'split_type_code' => '1600',
            'split_type_name' => 'ハード',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '7',
            'split_type_code' => '1610',
            'split_type_name' => 'ソフト',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '8',
            'split_type_code' => '1700',
            'split_type_name' => 'コンサルティング',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '9',
            'split_type_code' => '1800',
            'split_type_name' => 'テナント収入',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '10',
            'split_type_code' => '1900',
            'split_type_name' => 'その他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductSplitType::create([
            'product_type_id' => '11',
            'split_type_code' => '2000',
            'split_type_name' => '社内売上高',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
