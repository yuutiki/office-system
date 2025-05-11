<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporationSearchModalDisplayItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'column_key',
        'display_name',
        'display_order',
        'is_visible'
    ];

    public static function getDisplayItems($screenId)
    {
        return self::where('screen_id', $screenId)
            ->where('is_visible', true)
            ->orderBy('display_order')
            ->get();
    }
}
