<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'type',
        'data',
        'source_model',
        'source_id',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function sourceModel()
    {
        return $this->morphTo('source_model', 'source_model', 'source_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
