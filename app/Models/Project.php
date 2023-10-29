<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add


class Project extends Model
{
    use HasFactory,Sortable;


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function distributionType()
    {
        return $this->belongsTo(DistributionType::class);
    }
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
    public function accountingType()
    {
        return $this->belongsTo(AccountingType::class);
    }
    public function salesStage()
    {
        return $this->belongsTo(SalesStage::class);
    }
    public function accountingPeriods()
    {
        return $this->hasmany(AccountingPeriod::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
