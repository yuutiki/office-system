<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use App\Observers\GlobalObserver;

class Link extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'display_name',
        'display_order',
        'url',
        'affiliation2_id',
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

    //sort
    public $sortable = [
        'display_name',
        'url',
        'display_order',
        'affiliation2_name',
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
}
