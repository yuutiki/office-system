<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class ClientPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'division_name',
        'position_name',
        'tel1',
        'fax1',
        'phone',
        'mail',
        'head_post_code',
        'prefecture_id',
        'head_address1',
        'person_memo',
        'is_retired',
        'is_billing_receiver',
        'is_payment_receiver',
        'is_support_info_receiver',
        'is_closing_info_receiver',
        'is_exhibition_info_receiver',
        'is_cloud_info_receiver',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
