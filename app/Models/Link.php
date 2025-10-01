<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use App\Observers\GlobalObserver;
use App\View\Composers\LinkComposer;

class Link extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'display_name',
        'display_order',
        'url',
        'affiliation2_id',
        'department_id',
        'created_by',
        'updated_by'
    ];

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);

        // モデルが保存（作成または更新）されたとき
        static::saved(function ($link) {
            LinkComposer::clearCache();
        });

        // モデルが削除されたとき
        static::deleted(function ($link) {
            LinkComposer::clearCache();
        });
    }

    //sort
    public $sortable = [
        'display_name',
        'url',
        'display_order',
        'affiliation2_name',
        'department_id',
    ];

    //relation
    public function affiliation2()
    {
        return $this->belongsTo(Affiliation2::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
