<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_stage_code',
        'sales_stage_name',
        'created_by',
        'updated_by'
    ];


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
