<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use App\Observers\GlobalObserver;
use Illuminate\Notifications\Notification;

class Report extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'client_id',
        'contact_at',
        'contact_type_id',
        'report_type_id',
        'report_title',
        'report_content',
        'report_notice',
        // 'client_representative',
        'is_draft',
        'project_id',
    ];

    // 型変換の定義
    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public static $rulesEdit = [
        'report_title' => 'required|max:255',
        'report_content' => 'required',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    // アクセス制御の定義
    protected static function booted()
    {
        // 下書きは作成者のみが閲覧可能
        static::addGlobalScope('accessControl', function ($query) {
            if (auth()->check()) {
                $query->where(function ($q) {
                    $q->where('is_draft', false)
                      ->orWhere(function ($q) {
                          $q->where('is_draft', true)
                               ->where('user_id', auth()->id());
                      });
                });
            }
        });
    }




    // キーワード検索用の関数
    public static function getSearchWordArray($keywords)
    {
        // 検索文字列全体の前後にある空白を除去
        $keywordsRemoveSpace = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $keywords);
        // 検索文字列内の半角スペースを全角スペースにする
        $keywordsUnifySpace =  mb_convert_kana($keywordsRemoveSpace, 's');
        // 全角空白で文字を区切り配列へ
        $keywordsArray = preg_split('/[\s]+/', $keywordsUnifySpace);

        return $keywordsArray;
    }
    
    // 複数単語のAND検索用のクエリ発行関数
    public static function getMultiWordSearchQuery($query, $searchTextArray)
    {
        // AND検索なので、最初の条件をwhereで追加し、以降はorWhereで条件を追加する
        $first = array_shift($searchTextArray);
        $query->where(function ($q) use ($first) {
            $q->where(function ($innerQ) use ($first) {
                $innerQ->where('report_title', 'like', '%' . $first . '%')
                    ->orWhere('report_content', 'like', '%' . $first . '%')
                    ->orWhere('report_notice', 'like', '%' . $first . '%');
            });
        });

        foreach ($searchTextArray as $searchText) {
            $query->where(function ($innerQ) use ($searchText) {
                $innerQ->where('report_title', 'like', '%' . $searchText . '%')
                    ->orWhere('report_content', 'like', '%' . $searchText . '%')
                    ->orWhere('report_notice', 'like', '%' . $searchText . '%');
            });
        }

        return $query;
    }






    // 中間テーブルreport_to_recipientsを介して報告内容が報告先（受信者）と関連するリレーションok
    // public function recipients()
    // {
    //     return $this->belongsToMany(User::class, 'report_to_recipients', 'report_id', 'recipient_id')
    //         ->withPivot('is_read')// pivotテーブルのreadカラムを取得する
    //         ->withTimestamps();
    // }

    // 報告に関連するコメントのリレーションok
    public function comments()
    {
        return $this->hasMany(Comment::class, 'report_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }
    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
    // 報告に関連する報告者（投稿者）のリレーションok
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function recipients()
    {
        return $this->belongsToMany(User::class, 'report_recipients')
                    ->withPivot('is_read', 'read_at')
                    ->withTimestamps();
    }

    // 顧客担当者との多対多
    public function clientContacts()
    {
        return $this->belongsToMany(ClientContact::class, 'client_contact_report');
    }

    public function attachContacts(array $contactIds)
    {
        $this->clientContacts()->sync($contactIds);
    }
}
