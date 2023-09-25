<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSplitType extends Model
{
    use HasFactory;

    //relation
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
