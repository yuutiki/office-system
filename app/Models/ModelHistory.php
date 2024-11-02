<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHistory extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'model',
        'model_type',
        'model_id',
        'user_id',
        'operation_type',
        'changes',
        'ip_address',
        'user_agent',
        'meta',
    ];

    protected $casts = [
        'changes' => 'array',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
