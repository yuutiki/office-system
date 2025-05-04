<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;

class AccountingPeriod extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'period_name',
        'period_start_at',
        'period_end_at',
        'created_by',
        'updated_by'
    ];
    
    protected $fillable = [
        'period_name',
        'period_start_at',
        'period_end_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'period_start_at' => 'datetime',
        'period_end_at' => 'datetime',
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }

    public function getDurationMonthsAttribute()
    {
        $start = Carbon::parse($this->period_start_at);
        $end = Carbon::parse($this->period_end_at);
        return $start->diffInMonths($end) + 1;
    }

    public function scopeCurrentPeriod($query)
    {
        return $query->where('period_start_at', '<=', now())
                     ->where('period_end_at', '>=', now());
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
}
