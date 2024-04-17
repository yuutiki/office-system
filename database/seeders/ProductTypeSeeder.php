<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        ProductType::create([
            'type_code' => 'PK',
            'type_name' => 'パッケージ・ライセンス',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'CU',
            'type_name' => 'カスタマイズ',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'IW',
            'type_name' => '導入作業',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'SS',
            'type_name' => 'サポート',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'CL',
            'type_name' => 'クラウド',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'PP',
            'type_name' => '他社仕入れ製品',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'PM',
            'type_name' => '他社仕入保守',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'CO',
            'type_name' => 'コンサルティング',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'TI',
            'type_name' => 'テナント収入',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'OO',
            'type_name' => 'その他',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        ProductType::create([
            'type_code' => 'IS',
            'type_name' => '社内売上高',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}