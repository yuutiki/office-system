<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Observers\GlobalObserver;

class ProjectRevenue extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'sales_year_month', 'amount'];

    public static function bulkInsert(array $data)
    {
        // テーブル名を指定して一括挿入
        DB::table('project_revenues')->insert($data);
    }

    //GlobalObserverに定義されている作成者と更新者を登録するメソッド
    //なお、値を更新せずにupdateをかけても更新者は更新されない。
    protected static function boot()
    {
        parent::boot();
        self::observe(GlobalObserver::class);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
