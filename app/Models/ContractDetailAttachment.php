<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractDetailAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_detail_id',
        'file_path',
        'file_size',
    ];

    public function contractDetail()
    {
        return $this->belongsTo(ContractDetail::class);
    }
}
