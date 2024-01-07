<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSplitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'split_type_code',
        'split_type_name',
        'created_by',
        'updated_by'
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    //relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
