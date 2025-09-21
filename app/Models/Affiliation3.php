<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Affiliation3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliation3_code',
        'affiliation3_prefix',
        'affiliation3_name',
        'affiliation3_name_kana',
        'affiliation3_name_en',
        'affiliation2_id',
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
    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }
}

