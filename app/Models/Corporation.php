<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use App\Observers\GlobalObserver;
use App\Traits\ModelHistoryTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Corporation extends Model
{
    use HasFactory;
    use Sortable;//add
    use ModelHistoryTrait;
    use HasUlids;

    protected $fillable = [
        'corporation_num',
        'corporation_name',
        'corporation_kana_name',
        'corporation_short_name',
        'corporation_post_code',
        'corporation_prefecture_id',
        'corporation_address1',
        'is_stop_trading',
        'stop_trading_reason',
        'tax_status',
        'corporation_number',
        'invoice_num',
        'invoice_at',  
        'is_active_invoice',
        'corporation_memo',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
        'corporation_num',
        'corporation_name',
        'corporation_kana_name',
        'corporation_prefecture_id',
        'prefecture.prefecture_code',
        'is_stop_trading',
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

        if (isset($filters['corporation_name'])) {
            $spaceConversion = mb_convert_kana($filters['corporation_name'], 's'); //全角スペース⇒半角スペースへ変換
            // $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
    
            $query->orWhere('corporation_name', 'like', '%' . $spaceConversion . '%');
            $query->orWhere('corporation_kana_name', 'like', '%' . $spaceConversion . '%');
            $query->orWhere('corporation_short_name', 'like', '%' . $spaceConversion . '%');
        }

        if (isset($filters['invoice_num'])) {
            $query->where('invoice_num', 'like', '%' . $filters['invoice_num'] . '%');
        }

        if (isset($filters['trade_status_ids'])) {
            $query->whereIn('is_stop_trading', $filters['trade_status_ids']);
        }

        if (isset($filters['tax_status_ids'])) {
            $query->whereIn('tax_status', $filters['tax_status_ids']);
        }

        // if (isset($filters['tax_status'])) {
        //     $query->where('tax_status', '=', $filters['tax_status']);
        // }
    }

    public static function storeWithTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // ロックをかけて最後の法人情報を取得
            $lastCorporation = Corporation::lockForUpdate()->orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->corporation_num : '000000';
            
            // 最後の番号をインクリメントして新しい番号を生成
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);
            
            $data['corporation_num'] = $newNumber;
    
            // データ登録
            $corporation = Corporation::create($data);
    
            return $corporation;
        });
    }

    

    // 法人正式名称のsetter（Mutator）を定義
    public function setCorporationNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['corporation_name'] = mb_convert_kana($value, 's');
    }

    // 法人正式カナ名称のsetter（Mutator）を定義
    public function setCorporationKanaNameAttribute($value)
    {
        // 全角スペースを半角スペースに変換して設定
        $this->attributes['corporation_kana_name'] = mb_convert_kana($value, 'KVs');
    }
    










    //
    // 以下CSVダウンロードロジック
    //

    // CSVヘッダーの生成
    private static function getCsvHeader() : Array
    {
        return['ID', '法人番号', '法人正式名', '法人正式カナ名', '法人略称', '法人備考', '顧客数', '作成者', '作成日時', '更新者', '更新日時'];
    }

    // 出力対象を検索条件から指定
    public static function searchCorporations($filters, $sortBy, $sortDirection)
    {
        return static::with(['createdBy', 'updatedBy', 'prefecture'])
            ->filter($filters) // scopeFilterメソッドを呼び出している
            ->orderBy($sortBy, $sortDirection)
            ->withCount('clients')
            ->get();
    }

    // 指定された出力対象を使ってCSVボディの生成
    public static function generateCsvData($corporations)
    {
        // CSVの内容を格納する配列を初期化
        $csvData = [];

        // 法人データをCSVデータに変換
        foreach ($corporations as $corporation) {
            $csvData[] = [
                $corporation->id,
                $corporation->corporation_num,
                $corporation->corporation_name,
                $corporation->corporation_kana_name,
                $corporation->corporation_short_name,
                $corporation->corporation_memo,
                $corporation->clients_count,
                optional($corporation->createdBy)->user_name,
                $corporation->created_at,
                optional($corporation->updatedBy)->user_name,
                $corporation->updated_at,
            ];
        }
        return $csvData;
    }

    // コントローラから検索条件を受取り、CSVファイルを生成
    public static function downloadCorporationCsv($filters, $sortBy, $sortDirection)
    {
        $corporations = static::searchCorporations($filters, $sortBy, $sortDirection);
        $csvData = static::generateCsvData($corporations);
        $fileName = '法人データ_' . date('YmdHis') . '.csv';
    
        return response()->streamDownload(function () use ($csvData)
        {
            $fileHandle = fopen('php://output', 'w'); // php://output ストリームを書き込みモードで開く
            fprintf($fileHandle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOMなしでUTF-8エンコーディング
            
            // ヘッダー行を書き込む
            fputcsv($fileHandle, static::getCsvHeader());
    
            // ボディー行を書き込む
            foreach ($csvData as $row) {
                fputcsv($fileHandle, $row);
            }
    
            fclose($fileHandle);
    
        },
        $fileName);
    }

    // protected function getHistoryMeta(): ?array
    // {
    //     return [
    //         'role' => $this->role,
    //         // その他のメタデータ
    //     ];
    // }



    // 以下リレーション設定
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class, 'corporation_prefecture_id', 'id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function credits()
    {
        return $this->hasMany(CorporationCredit::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}