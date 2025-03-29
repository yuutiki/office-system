<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;// add
use Illuminate\Support\Facades\DB;// add
use Illuminate\Support\Str;//add
use App\Observers\GlobalObserver;
use App\Traits\ModelHistoryTrait;

class Support extends Model
{
    use HasFactory;
    use Sortable;
    use ModelHistoryTrait;

    protected $fillable = [
        'client_id',
        'request_num',
        'received_at',
        'title',
        'is_draft',
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
    ];

    //ソート用に使うカラムを指定
    public $sortable = [
        'client_id',
        'request_num',
        'received_at',
        'title',
        'is_draft',
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
    ];

    // JOIN したテーブルのカラムをソート可能にする
    public $sortableAs = ['client_user_kana_name'];

    /**
     * Client 経由で User の user_kana_name でソート
     */
    public function clientUserKanaNameSortable($query, $direction)
    {
        return $query
            ->leftJoin('clients', 'supports.client_id', '=', 'clients.id')
            ->leftJoin('users', 'clients.user_id', '=', 'users.id') // clients 経由で users に JOIN
            ->orderBy('users.user_kana_name', $direction);
    }


    public static function createSupport(array $data)
    {
        // 問合せ連番を採番
        $data['request_num'] = self::generateRequestNumber($data['client_id']);

        // Boolean型のチェックボックスを適切にセット
        $data['is_finished'] = isset($data['is_finished']) ? 1 : 0;
        $data['is_disclosured'] = isset($data['is_disclosured']) ? 1 : 0;
        $data['is_confirmed'] = isset($data['is_confirmed']) ? 1 : 0;
        $data['is_troubled'] = isset($data['is_troubled']) ? 1 : 0;
        $data['is_faq_target'] = isset($data['is_faq_target']) ? 1 : 0;

        return self::create($data);
    }

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

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
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
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}