<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectRevenue extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'sales_year_month', 'amount'];

    public static function bulkInsert(array $data)
    {
        // テーブル名を指定して一括挿入
        DB::table('project_revenues')->insert($data);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
