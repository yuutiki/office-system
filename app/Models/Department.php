<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_code',
        'prefix_code',
        'department_name',
        'department_kana_name',
        'department_eng_name',
        'department_short_name',
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


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    //relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
