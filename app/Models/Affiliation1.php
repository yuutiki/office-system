<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class Affiliation1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliation1_code',
        'affiliation1_prefix',
        'affiliation1_name',
        'affiliation1_kana_name',
        'affiliation1_eng_name',
        'affiliation1_name_short',
        'affiliation1_post_code',
        'affiliation1_prefecture_id',
        'affiliation1_address1',
        'company_TEL',
        'company_FAX',
        'company_stamp_image',
        'company_logo_image',
        'company_president_position_name',
        'company_president_id',
        'corporation_number',
        'stock_code',
        'invoice_num',
        'invoice_at',
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


    public function projects()//relation
    {
        return $this->hasMany(Project::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function users()//relation
    {
        return $this->hasMany(User::class);
    }
}
