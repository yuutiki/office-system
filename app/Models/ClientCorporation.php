<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use App\Observers\GlobalObserver;


class ClientCorporation extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name',
        'clientcorporation_short_name',
        'memo',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name'
    ];

    // バリデーションルール
    public static $rules = [
        'clientcorporation_num' => 'size:6',
        'clientcorporation_name' => 'required|max:1024',
        'clientcorporation_kana_name' => 'required|max:1024',
        'clientcorporation_short_name' => 'required|max:1024',
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
        if (isset($filters['s_clientcorporation_num'])) {
            $query->where('clientcorporation_num', 'like', '%' . $filters['s_clientcorporation_num']);
        }

        if (isset($filters['s_clientcorporation_name'])) {
            $spaceConversion = mb_convert_kana($filters['s_clientcorporation_name'], 's'); //全角スペース⇒半角スペースへ変換
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($wordArraySearched as $value) {
                $query->where('clientcorporation_name', 'like', '%' . $value . '%');
                }
        }

        if (isset($filters['s_clientcorporation_kana_name'])) {
            $query->where('clientcorporation_kana_name', 'like', '%' . $filters['s_clientcorporation_kana_name'] . '%');
        }
    }



    public static function storeWithTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // ロックをかけて最後の法人情報を取得
            $lastCorporation = ClientCorporation::lockForUpdate()->orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->clientcorporation_num : '000000';
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);

            $data['clientcorporation_num'] = $newNumber;

            // データ登録
            $corporation = ClientCorporation::create($data);

            return $corporation;
        });
    }

    



    

    // 法人正式名称のsetter（Mutator）を定義
    public function setClientcorporationNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['clientcorporation_name'] = mb_convert_kana($value, 's');
    }

    // 法人正式カナ名称のsetter（Mutator）を定義
    public function setClientcorporationKanaNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['clientcorporation_kana_name'] = mb_convert_kana($value, 'KVs');
    }
    
    public function clients()//relation
    {
        return $this->hasMany(Client::class);
    }
}
