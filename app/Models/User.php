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


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_num',
        'kana_name',
        'access_ip',
        'last_login_at',
        'role_id',
        'employee_status_id',
        'profile_image',
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
        'name',
        'email',
        'role_id',
        'last_login_at'
    ];

    public static function rules($id)
    {
        return [
            'affiliation1_id_' . $id => 'required',
            'department_id_' . $id => 'required',
            'affiliation3_id_' . $id => 'required',
            'int_phone_' . $id => 'size:3',
            'kana_name_' . $id => 'required|max:50',
            'name_' . $id => 'required|max:50',
            // 他のフィールドに対するルールも追加する
        ];
    }

    public static $uploadRules = [
        'csv_input' => 'required|file|mimes:csv,txt',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();

        self::observe(GlobalObserver::class);
    }

    

    //relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employee_status()
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
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function affiliation3()
    {
        return $this->belongsTo(Affiliation3::class);
    }

    public function roleGroups()
    {
        return $this->belongsToMany(RoleGroup::class, 'user_rolegroup');
    }

}
