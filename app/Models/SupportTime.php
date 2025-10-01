<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Kyslik\ColumnSortable\Sortable;

class SupportTime extends Model
{
    use HasFactory, Sortable;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'code',
        'name',
        'created_by',
        'updated_by',
        'is_active',
    ];

    /**
     * ソート可能なカラム
     */
    public $sortable = [
        'code',
        'name',
        'is_active', 
        'updated_at'
    ];


    /**
     * スコープ：有効なレコードのみ
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * スコープ：無効なレコードのみ
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }


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
}
