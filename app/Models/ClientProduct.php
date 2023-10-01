<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProduct extends Model
{
    use HasFactory;

    protected $table = 'client_products';

    // 他のモデルとのリレーションを定義
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // 他のモデルとのリレーションを定義
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function productVersion()
    {
        return $this->belongsTo(ProductVersion::class, 'product_version_id');
    }
}
