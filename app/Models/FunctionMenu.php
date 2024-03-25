<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionMenu extends Model
{
    use HasFactory;

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function roleGroups()
    {
        return $this->belongsToMany(RoleGroup::class)->withPivot('permission_id');
    }
}
