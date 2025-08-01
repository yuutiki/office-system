<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Kyslik\ColumnSortable\Sortable;

class ReportType extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'report_type_code',
        'report_type_name',
        'created_by',
        'updated_by'
    ];

    protected $fillable = [
        'report_type_code',
        'report_type_name',
        'created_by',
        'updated_by'
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }


    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}