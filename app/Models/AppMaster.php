<?php

namespace App\Models;

use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AppMaster extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'master_type',
        'master_code',
        'master_name',
        'master_name_en',
        'route',
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
}
