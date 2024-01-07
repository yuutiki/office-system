<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_type_code',
        'distribution_type_name',
        'created_by',
        'updated_by'
    ];


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
