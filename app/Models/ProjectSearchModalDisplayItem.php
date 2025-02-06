<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSearchModalDisplayItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'column_key',
        'display_default_name',
        'display_name',
        'display_order',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'display_order' => 'integer'
    ];
}
