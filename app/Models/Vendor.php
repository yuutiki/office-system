<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Str;//add


class Vendor extends Model
{
    use HasFactory;
    use Sortable;


    public static function generateVendorNumber($clientcorporationNum, $prefix_code)
    {
        $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
        $lastVendor = Vendor::where('vendor_num', 'like', "$clientcorporationNum-V-$suffix%")
            ->orderBy('vendor_num', 'desc')
            ->first();

        if ($lastVendor) {
            $lastSerialNumber = (int) Str::substr($lastVendor->vendor_num, -2);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '01';
        }

        return "$clientcorporationNum-V-$suffix$newSerialNumber";
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
