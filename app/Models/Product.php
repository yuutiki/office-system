<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;// add
use Illuminate\Support\Facades\DB;// add
use App\Observers\GlobalObserver;
use App\Traits\ModelHistoryTrait;

class Product extends Model
{
    use HasFactory;
    use Sortable;
    use ModelHistoryTrait;

    protected $fillable = [
        'product_code',
        'product_maker_id',
        'affiliation2_id',
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
        'affiliation2_id',
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

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    public static function generateProductCode($productMaker, $affiliation2, $productType, $productSplitType)
    {
        $partialProductCode = $productMaker->maker_code . $affiliation2->affiliation2_prefix . $productType->type_code . $productSplitType->split_type_code;

        // 同じ組み合わせのレコードから連番部分を抽出し、最大値に+1する
        $maxSerialNumber = self::where([
            'product_maker_id' => $productMaker->id,
            'affiliation2_id' => $affiliation2->id,
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


    /**
     * 履歴表示用の名称を取得
     */
    protected function getHistoryDisplayName(): string
    {
        return "{$this->product_name}（{$this->product_code}）";
    }

    /**
     * 履歴に追加のメタ情報を含める場合
     */
    protected function getAdditionalHistoryMeta(): array
    {
        return [
            'product_code' => $this->product_code,
            // 他の必要な情報
        ];
    }
   
    //relation
    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }
    public function productSplitType()
    {
        return $this->belongsTo(ProductSplitType::class);
    }
    public function productSeries()
    {
        return $this->belongsTo(ProductSeries::class);
    }
    // public function clients()
    // {
    //     return $this->belongsToMany(Client::class);
    // }
    // public function clients()
    // {
    //     return $this->belongsToMany(Client::class, 'client_products', 'product_id', 'client_id');
    // }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_products');
    }

}
