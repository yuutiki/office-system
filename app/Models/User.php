<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;//add


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Sortable;

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
        'name_kana',
        'access_ip',
        'last_login_at',
        'role_id',
        'employee_status'
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
        'email'
    ];


    //relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employee_status()
    {
        return $this->belongsTo(Employee_status::class);
    }

    public function keepfiles()
    {
        return $this->belongsToMany(Keepfile::class);
    }
}
