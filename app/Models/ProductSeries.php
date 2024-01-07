<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_code',
        'series_name',
        'created_by',
        'updated_by'
    ];


    //relation
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
