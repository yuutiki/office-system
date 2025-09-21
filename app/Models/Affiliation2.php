<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Affiliation2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'Affiliation2_code',
        'Affiliation2_prefix',
        'Affiliation2_name',
        'Affiliation2_name_kana',
        'Affiliation2_name_en',
        'Affiliation2_name_short',
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
    public function affiliation1()
    {
        return $this->belongsTo(Affiliation1::class);
    }
    
}
