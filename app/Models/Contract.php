<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    
    public function contractChangeType()
    {
        return $this->belongsTo(ContractChangeType::class);
    }
    public function contractUpdateType()
    {
        return $this->belongsTo(ContractUpdateType::class);
    }
    public function contractPartnerType()
    {
        return $this->belongsTo(ContractPartnerType::class);
    }
    public function contractsheetStatus()
    {
        return $this->belongsTo(ContractsheetStatus::class);
    }
}
