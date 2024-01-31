<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class ProductSplitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'split_type_code',
        'split_type_name',
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

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    //relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
