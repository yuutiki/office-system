<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_status_code',
        'trade_status_name',
        'created_by',
        'updated_by'
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function clients()
    {
        return $this->hasmany(Client::class);
    }
}
