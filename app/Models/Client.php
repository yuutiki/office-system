<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;//add
use Kyslik\ColumnSortable\Sortable;//add

class Client extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'client_num',
        'client_name',
        'client_kana_name',
        'client_corporation_id',
        'user_id',
        'client_type_id',
        'trade_status_id',
        'installation_type_id',
        'memo',
    ];

    //ソート用に使うカラムを指定
    public $sortable = [
        'client_num',
        'client_name',
        'client_kana_name',
        'client_corporation_id'
    ];

    // public static function generateClientNumber($clientcorporationId)
    // {
    //     // ロックをかけて同時実行を防止する
    //     DB::beginTransaction();

    //     try {
    //         // 最新の顧客番号を取得する
    //         $latestClient = static::where('client_corporation_id', $clientcorporationId)
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if ($latestClient) {
    //             // 最新の顧客番号が存在する場合、枝番をインクリメントして新しい顧客番号を生成する
    //             $latestClientNumber = $latestClient->client_num;
    //             $branchNumber = intval(substr($latestClientNumber, -2)) + 1;
    //             $newClientNumber = sprintf("%06d", $clientcorporationId) . '-' . str_pad($branchNumber, 2, '0', STR_PAD_LEFT);
    //             // $newClientNumber = substr($latestClientNumber, 0, -2) . '-' . str_pad($branchNumber, 2, '0', STR_PAD_LEFT);
    //         } else {
    //             // 最新の顧客番号が存在しない場合、初期値として'01'を設定する
    //             // $newClientNumber = $clientcorporationId . '-01';
    //             $newClientNumber = sprintf("%06d", $clientcorporationId) . '-01';
    //         }

    //         // 新しい顧客番号を返す
    //         DB::commit();
    //         return $newClientNumber;
    //     } catch (\Exception $e) {
    //         // エラーが発生した場合はロールバックする
    //         DB::rollBack();
    //         throw $e;
    //     }
    // }


    //relation
    public function clientCorporation()
    {
        return $this->belongsTo(ClientCorporation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }
    public function installationType()
    {
        return $this->belongsTo(InstallationType::class);
    }
    public function tradeStatus()
    {
        return $this->belongsTo(TradeStatus::class);
    }

    public function reports()
    {
        return $this->hasmay(Report::class);
    }
}
