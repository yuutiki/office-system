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
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // 他のモデルとのリレーションを定義
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function productVersion()
    {
        return $this->belongsTo(ProductVersion::class, 'product_version_id' ,'id');
    }
    // 作成者とのリレーション
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // 更新者とのリレーション
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
