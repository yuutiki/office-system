<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Affiliation4 extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliation4_code',
        'affiliation4_prefix',
        'affiliation4_name',
        'affiliation4_name_kana',
        'affiliation4_name_en',
        'affiliation4_name_short',
        'is_active',
        'affiliation3_id',
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
    public function affiliation3()
    {
        return $this->belongsTo(Affiliation3::class);
    }
}

