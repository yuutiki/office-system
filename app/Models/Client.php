<?php

namespace App\Models;

use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;//add
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Str;//add
use App\Traits\ModelHistoryTrait;


class Client extends Model
{
    use HasFactory;
    use Sortable;//add
    use ModelHistoryTrait;

    protected $fillable = [
        'client_num',
        'client_name',
        'client_kana_name',
        'corporation_id',
        'user_id',
        'client_type_id',
        'trade_status_id',
        'installation_type_id',
        'post_code',
        'prefecture_id',
        'address_1',
        'memo',
        'created_by',
        'updated_by',
    ];

 

    //ソート用に使うカラムを指定
    public $sortable = [
        'client_num',
        'client_name',
        'client_kana_name',
        // 'corporation_id',
        // 'user_id',
        // 'user.user_kana_name',
        // 'corporation.corporation_kana_name'  
    ];


    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    //郵便番号のフォーマット変換を行うメソッド
    public static function formatPostCode($postCode)
    {
        if (!isset($postCode)) {
            return null;
        }

        $postCode = mb_convert_kana($postCode, "n"); // 半角変換
        $postCode = preg_replace("/[^0-9]/", "", $postCode); // 数字以外を削除

        if (mb_strlen($postCode) != 7) {
            return "郵便番号の桁数が正しくありません";
        }

        $postCode_01 = substr($postCode, 0, 3);
        $postCode_02 = substr($postCode, -4, 4);
        $formattedPostCode = "{$postCode_01}-{$postCode_02}";

        return $formattedPostCode;
    }


    public static function generateClientNumber($corporationNum)
    {
        // $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
        $lastClient = Client::where('client_num', 'like', "$corporationNum-C-%")
            ->orderBy('client_num', 'desc')
            ->first();

        if ($lastClient) {
            $lastSerialNumber = (int) Str::substr($lastClient->client_num, -3);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '001';
        }

        return "$corporationNum-C-$newSerialNumber";
    }
    // public static function generateClientNumber($corporationNum, $prefix_code)
    // {
    //     $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
    //     $lastClient = Client::where('client_num', 'like', "$corporationNum-C-$suffix%")
    //         ->orderBy('client_num', 'desc')
    //         ->first();

    //     if ($lastClient) {
    //         $lastSerialNumber = (int) Str::substr($lastClient->client_num, -2);
    //         $newSerialNumber = str_pad($lastSerialNumber + 1, 2, '0', STR_PAD_LEFT);
    //     } else {
    //         $newSerialNumber = '01';
    //     }

    //     return "$corporationNum-C-$suffix$newSerialNumber";
    // }

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

    /**
     * 履歴表示用の名称を取得
     */
    protected function getHistoryDisplayName(): string
    {
        return "{$this->client_name}（{$this->client_num}）";
    }

    /**
     * 履歴に追加のメタ情報を含める場合
     */
    protected function getAdditionalHistoryMeta(): array
    {
        return [
            'client_num' => $this->client_num,
            // 他の必要な情報
        ];
    }


    //relation
    public function corporation()
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
    }
    public function dealer() // Vendorとのリレーション
    {
        return $this->belongsTo(Vendor::class, 'dealer_id'); // 'dealer_id'がClientテーブルのvendor_idを参照することを示す
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
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
        return $this->hasMany(Report::class);
    }
    public function supports()
    {
        return $this->hasMany(Support::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'client_products', 'client_id', 'product_id');
    // }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'client_products');
    }

    public function clientProducts()
    {
        return $this->hasMany(ClientProduct::class);
    }

    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function clientContacts()
    {
        return $this->hasMany(ClientContact::class);
    }


}
