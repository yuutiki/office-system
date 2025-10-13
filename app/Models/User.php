<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule as ValidationRule;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;//add
use App\Observers\GlobalObserver;
use App\Traits\ModelHistoryTrait;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, ModelHistoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_num',
        'user_name',
        'user_kana_name',
        'birth',
        'employment_at',
        'employee_status_id',
        'email',
        'int_phone',
        'ext_phone',
        'department_id',
        'profile_image',
        'is_enabled',
        'password',
        'password_change_required',
        'access_ip',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //sort
    public $sortable = [
        'user_num',
        'user_name',
        'email',
        'last_login_at'
    ];



    // index画面の検索ロジック
    public function scopeFilter($query, $filters)
    {
        // システム管理者でない場合は、id1のユーザーを非表示
        if (!$this->isSysAdmin()) {
            $query->where('id', '!=', 1);
        }

        // 社員番号
        if (!empty($filters['user_num'])) {
            $query->where('user_num', 'LIKE', '%' . $filters['user_num'] . '%');
        }

        // 氏名・カナ検索（スペース区切り対応）
        if (!empty($filters['user_name'])) {
            $spaceConversion = mb_convert_kana($filters['user_name'], 's'); // 全角スペース⇒半角スペース
            $keywords = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($sub) use ($word) {
                        $sub->where('user_name', 'LIKE', "%{$word}%")
                            ->orWhere('user_kana_name', 'LIKE', "%{$word}%");
                    });
                }
            });
        }

        // 雇用ステータス
        if (!empty($filters['employee_status_ids'])) {
            $query->whereIn('employee_status_id', $filters['employee_status_ids']);
        }

        return $query;
    }


    private function isSysAdmin()
    {
        return Auth::check() && Auth::user()->id === 1;
    }


    /**
     * 履歴表示用の名称を取得(ModelHistoryTrait)
     */
    protected function getHistoryDisplayName(): string
    {
        return "{$this->user_name}（{$this->user_num}）";
    }

    /**
     * 履歴に追加のメタ情報を含める場合(ModelHistoryTrait)
     */
    protected function getAdditionalHistoryMeta(): array
    {
        return [
            'user_num' => $this->user_num,
            // 他の必要な情報
        ];
    }

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    public function isSystemAdmin(): bool
    {
        return $this->role === config('sytemadmin.system_admin');
    }

    /**
     * 指定レポートを受信しているか？
     */
    public function hasReceivedReport(Report $report): bool
    {
        return $this->receivedReports->contains('id', $report->id);
    }

    /**
     * 指定レポートを既読にしているか？
     */
    public function hasReadReport(Report $report): bool
    {
        $pivot = $this->receivedReports->firstWhere('id', $report->id)?->pivot;
        return $pivot?->is_read ?? false;
    }

    /**
     * ユーザーの所属階層を取得（部門パス）
     */
    public function getDepartmentHierarchy(): array
    {
        return $this->department
            ? $this->department->getHierarchyPath()
            : [];
    }
    

    //relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employeeStatus()
    {
        return $this->belongsTo(Employeestatus::class);
    }

    //預託データに関するリレーション
    public function keepfiles()
    {
        return $this->belongsToMany(Keepfile::class);
    }

    //担当顧客に関するリレーション
    public function clients()
    {
        return $this->hasmany(Client::class);
    }

    // 中間テーブルreport_to_recipientsを介して報告先(受信者)が報告内容とリレーションok
    public function recipients()
    {
        return $this->belongsToMany(Report::class, 'report_to_recipients', 'recipient_id', 'report_id')
            ->withTimestamps();
    }

    //営業報告に対するリレーション(報告者としての)ok
    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    //営業報告のコメントに対するリレーションok
    public function comments()
    {
        return $this->hasMany(Comment::class,'user_id');
    }

    public function affiliation1()
    {
        return $this->belongsTo(Affiliation1::class);
    }

    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }

    public function affiliation3()
    {
        return $this->belongsTo(Affiliation3::class);
    }

    public function roleGroups()
    {
        return $this->belongsToMany(RoleGroup::class, 'user_rolegroup');
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function receivedReports()
    {
        return $this->belongsToMany(Report::class, 'report_recipients')
                    ->withPivot('is_read', 'read_at')
                    ->withTimestamps();
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
