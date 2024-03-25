<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_code',
        'permission_name',
        'description',
        'created_by',
        'updated_by',
    ];

    // リレーションの定義
    public function functionMenus()
    {
        return $this->hasMany(FunctionMenu::class);
    }
}
