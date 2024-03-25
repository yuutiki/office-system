<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolegroup extends Model
{
    use HasFactory;

    protected $table = 'user_rolegroup';
protected $fillable = ['role_group_id', 'user_id'];
}
