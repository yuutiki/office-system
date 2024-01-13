<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;// add
use Illuminate\Support\Facades\DB;// add
use Illuminate\Support\Str;//add


class Support extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'client_id',
        'request_num',
        'received_at',
        'title',
        'request_content',
        'response_content',
        'internal_message',
        'internal_memo1',
        'support_type_id',
        'support_time_id',
        'user_id',
        'client_user_department',
        'client_user_kana_name',
        'product_series_id',
        'product_version_id',
        'product_category_id',
        'is_finished',
        'is_disclosured',
        'is_confirmed',
        'is_troubled',
        'is_faq_target',
        'created_by',
        'updated_by'
    ];

    //ソート用に使うカラムを指定
    public $sortable = [
        'client_id',
        'request_num',
        'received_at',
        'title',
        'request_content',
        'response_content',
        'internal_message',
        'internal_memo1',
        'support_type_id',
        'support_time_id',
        'user_id',
        'client_user_department',
        'client_user_kana_name',
        'product_series_id',
        'product_version_id',
        'product_category_id',
        'is_finished',
        'is_disclosured',
        'is_confirmed',
        'is_troubled',
        'is_faq_target',
        'created_by',
        'updated_by'
    ];

    // バリデーションルール
    public static $rules = [
        'client_num' => 'required|size:10',
        'f_received_at' =>  'required',
        'f_title' => 'required|max:500',
        'f_support_type_id' => 'required',
        'f_support_time_id' => 'required',
        'f_user_id' => 'required',
        'f_product_series_id' => 'required',
        'f_product_version_id' => 'required',
        'f_product_category_id' => 'required',
    ];

    public static function generateRequestNumber($clientId)
    {
        $lastRequest = Support::where('client_id', 'like', "$clientId")
            ->orderBy('request_num', 'desc')
            ->first();

        if ($lastRequest) {
            $lastSerialNumber = (int) Str::substr($lastRequest->request_num, -4);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '0001';
        }

        return "$newSerialNumber";
    }

        // キーワード検索用の関数
        public static function getSearchWordArray($keyword)
        {
            // 検索文字列全体の前後にある空白を除去
            $keywordRemoveSpace = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $keyword);
            // 検索文字列内の半角スペースを全角スペースにする
            $keywordUnifySpace =  mb_convert_kana($keywordRemoveSpace, 's');
            // 全角空白で文字を区切り配列へ
            $keywordArray = preg_split('/[\s]+/', $keywordUnifySpace);
    
            return $keywordArray;
        }
    
// 複数単語のAND検索用のクエリ発行関数
public static function getMultiWordSearchQuery($query, $searchTextArray)
{
    // AND検索なので、最初の条件をwhereで追加し、以降はandWhereで条件を追加する
    $first = array_shift($searchTextArray);
    $query->where(function ($q) use ($first) {
        $q->where(function ($innerQ) use ($first) {
            $innerQ->where('title', 'like', '%' . $first . '%')
                ->orWhere('request_content', 'like', '%' . $first . '%')
                ->orWhere('response_content', 'like', '%' . $first . '%')
                ->orWhere('internal_message', 'like', '%' . $first . '%')
                ->orWhere('internal_memo1', 'like', '%' . $first . '%');
        });
    });

    foreach ($searchTextArray as $searchText) {
        $query->where(function ($innerQ) use ($searchText) {
            $innerQ->where('title', 'like', '%' . $searchText . '%')
                ->orWhere('request_content', 'like', '%' . $searchText . '%')
                ->orWhere('response_content', 'like', '%' . $searchText . '%')
                ->orWhere('internal_message', 'like', '%' . $searchText . '%')
                ->orWhere('internal_memo1', 'like', '%' . $searchText . '%');
        });
    }

    return $query;
}
        

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productSeries()
    {
        return $this->belongsTo(ProductSeries::class);
    }
    public function productVersion()
    {
        return $this->belongsTo(ProductVersion::class);
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function supportType()
    {
        return $this->belongsTo(SupportType::class);
    }

    public function supportTime()
    {
        return $this->belongsTo(SupportTime::class);
    }
}
