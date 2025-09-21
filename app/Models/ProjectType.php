<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;
use Kyslik\ColumnSortable\Sortable;

class ProjectType extends Model
{
    use HasFactory, Sortable;

    public $sortable = [
        'project_type_code',
        'project_type_name',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $fillable = [
        'project_type_code',
        'project_type_name',
        'is_active',
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
