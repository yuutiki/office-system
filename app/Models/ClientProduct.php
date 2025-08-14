<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Kyslik\ColumnSortable\Sortable;

class ClientProduct extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'client_id',
        'product_id',
        'quantity',
        'product_version_id',
        'is_customized',
        'is_contracted',
        'install_memo',
        'created_by',
        'updated_by',
    ];


    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }
    
    // 他のモデルとのリレーションを定義
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // 他のモデルとのリレーションを定義
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function productSeries()
    {
        return $this->belongsTo(ProductSeries::class, 'product_series_id', 'id');
    }
    public function productVersion()
    {
        return $this->belongsTo(ProductVersion::class, 'product_version_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
