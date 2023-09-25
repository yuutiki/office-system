<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;// add
use Illuminate\Support\Facades\DB;// add


class Product extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'product_code',
        'product_maker_id',
        'department_id',
        'product_type_id',
        'product_split_type_id',
        'product_series_id',
        'product_name',
        'product_short_name',
        'unit_price',
        'is_stop_selling',
        'is_listed',
        'product_memo1',
        'product_memo2',
        'created_by',
        'updated_by',
    ];

    //ソート用に使うカラムを指定
    public $sortable = [
        'product_maker_id',
        'department_id',
        'product_type_id',
        'product_split_type_id',
        'product_series_id',
        'product_code',
        'product_short_name',
        'unit_price',
        'is_stop_selling',
        'is_listed',
        'product_memo1',
        'product_memo2',
        'created_by',
        'updated_by'
    ];

    public static function generateProductCode($productMaker, $department, $productType, $productSplitType)
    {
        $partialProductCode = $productMaker->maker_code . $department->prefix_code . $productType->type_code . $productSplitType->split_type_code;

        // 同じ組み合わせのレコードから連番部分を抽出し、最大値に+1する
        $maxSerialNumber = self::where([
            'product_maker_id' => $productMaker->id,
            'department_id' => $department->id,
            'product_type_id' => $productType->id,
            'product_split_type_id' => $productSplitType->id,
        ])->max(DB::raw('CAST(SUBSTRING(product_code, -4) AS SIGNED)'));
    
        if ($maxSerialNumber !== null) {
            // 最大の連番を取得し+1する
            $nextSerialNumber = str_pad($maxSerialNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // レコードが存在しない場合、連番は '0001' からスタート
            $nextSerialNumber = '0001';
        }
    
        // 生成した連番を製品コードの一部に結合
        $productCode = $partialProductCode . $nextSerialNumber;
    
        return $productCode;
    }
   
    //relation
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function productSplitType()
    {
        return $this->belongsTo(ProductSplitType::class);
    }
    public function productSeries()
    {
        return $this->belongsTo(ProductSeries::class);
    }
}
