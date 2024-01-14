<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliation3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliation3_code',
        'affiliation3_prefix',
        'affiliation3_name',
        'affiliation3_name_kana',
        'affiliation3_name_en',
        'affiliation2_id',
        'created_by',
        'updated_by'
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}

