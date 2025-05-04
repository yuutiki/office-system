<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Kyslik\ColumnSortable\Sortable;

class ClientContact extends Model
{
    use HasFactory, HasUlids, Sortable;

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
        'post_code',
        'prefecture_id',
        'address_1',
        'client_contact_memo',
        'is_retired',
        'is_billing_receiver',
        'is_payment_receiver',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    // index画面の検索ロジック
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['corporation_num'])) {
            $query->where('corporation_num', 'like', '%' . $filters['corporation_num'] . '%');
        }

        if (!empty($filters['client_info'])) {
            $spaceConversion = mb_convert_kana($filters['client_info'], 's');
    
            $query->where(function ($query) use ($spaceConversion) {
                // 自分のカラムに対する検索（例）
                $query->orWhere('last_name', 'like', '%' . $spaceConversion . '%')
                      ->orWhere('first_name', 'like', '%' . $spaceConversion . '%');
    
                // 親テーブル（clients）のカラムに対する検索
                $query->orWhereHas('client', function ($q) use ($spaceConversion) {
                    $q->where('client_num', 'like', '%' . $spaceConversion . '%')
                      ->orWhere('client_name', 'like', '%' . $spaceConversion . '%');
                });
            });
        }

        return $query;

        if (isset($filters['invoice_num'])) {
            $query->where('invoice_num', 'like', '%' . $filters['invoice_num'] . '%');
        }

        if (isset($filters['trade_status_ids'])) {
            $query->whereIn('is_stop_trading', $filters['trade_status_ids']);
        }

        if (isset($filters['tax_status_ids'])) {
            $query->whereIn('tax_status', $filters['tax_status_ids']);
        }
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function checkboxOptions()
    {
        return $this->belongsToMany(ClientContactCheckboxOption::class, 'client_contact_checkbox_values', 'client_contact_id', 'checkbox_option_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
