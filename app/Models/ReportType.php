<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type_code',
        'report_type_name',
        'created_by',
        'updated_by'
    ];


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}