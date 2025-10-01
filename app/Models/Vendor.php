<?php

namespace App\Models;

use App\Observers\GlobalObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Str;//add


class Vendor extends Model
{
    use HasFactory, Sortable, HasUlids;

    protected $keyType = 'ulid'; // 主キーの型をulidに設定
    protected $primaryKey = 'ulid'; // 主キー名をulidに設定
    public $incrementing = false; // 自動インクリメントを無効化

    protected $fillable = [
        'vendor_num',
        'vendor_name',
        'vendor_kana_name',
        'corporation_id',
        'department_id',
        'vendor_type_id',
        'vendor_post_code',
        'vendor_prefecture_id',
        'vendor_address1',
        'vendor_tel',
        'vendor_fax',
        'number_of_employees',
        'vendor_memo',
        'vendor_url',
        'is_supplier',
        'is_dealer',
        'is_lease',
        'is_other_partner',
        'bank_code',
        'branch_code',
        'account_type',
        'account_number',
        'account_name',
    ];

    /**
     * 検索条件を適用するスコープ
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 業者区分（取引種別）フラグ
        if (!empty($filters['is_dealer'])) {
            $query->where('is_dealer', 1);
        }
        if (!empty($filters['is_supplier'])) {
            $query->where('is_supplier', 1);
        }
        if (!empty($filters['is_lease'])) {
            $query->where('is_lease', 1);
        }
        if (!empty($filters['is_other_partner'])) {
            $query->where('is_other_partner', 1);
        }

        // 業者種別
        if (!empty($filters['vendor_types'])) {
            $query->whereIn('vendor_type_id', $filters['vendor_types']);
        }

        // 業者名
        if (!empty($filters['vendor_name'])) {
            $query->where('vendor_name', 'like', '%' . $filters['vendor_name'] . '%');
        }

        // 部署（子孫含む）
        if (!empty($filters['selected_department']) && $filters['selected_department'] != 0) {
            $department = Department::find($filters['selected_department']);
            if ($department) {
                $ids = $department->getDescendantIds();
                $query->whereIn('department_id', $ids);
            }
        } elseif (!empty($filters['user_department'])) {
            // 初期表示はログインユーザー所属部門で絞る
            $query->where('department_id', $filters['user_department']);
        }

        return $query;
    }








    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    public static function generateVendorNumber($corporationNum)
    {
        // $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
        $lastVendor = Vendor::where('vendor_num', 'like', "$corporationNum-V-%")
            ->orderBy('vendor_num', 'desc')
            ->first();

        if ($lastVendor) {
            $lastSerialNumber = (int) Str::substr($lastVendor->vendor_num, -3);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '001';
        }

        return "$corporationNum-V-$newSerialNumber";
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



    //relation
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }
    public function clients()
    {
        return $this->hasMany(Client::class, 'dealer_id'); // 'dealer_id'がClientテーブルのvendor_idを参照することを示す
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function vendorType()
    {
        return $this->belongsTo(VendorType::class);
    }
    public function tradeStatus()
    {
        return $this->belongsTo(TradeStatus::class);
    }
    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
}
