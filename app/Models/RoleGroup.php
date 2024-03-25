<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_group_code',
        'role_group_name',
        'role_group_eng_name',
        'role_group_memo',
        'created_by',
        'updated_by',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rolegroup');
    }

    public function UserRolegroups()
    {
        return $this->hasMany(UserRolegroup::class);
    }

    // FunctionMenuモデルとの多対多のリレーションを定義する
    // public function functionMenus()
    // {
    //     return $this->belongsToMany(FunctionMenu::class)->withPivot('permission')->withTimestamps();
    // }
    public function functionMenus()
    {
        return $this->belongsToMany(FunctionMenu::class)->withPivot('permission_id');
    }

}
