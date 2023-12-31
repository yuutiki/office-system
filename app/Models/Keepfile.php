<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Carbon\Carbon; //add

class Keepfile extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'project_num',
        'clientname',
        'purpose',
        'keep_at',
        'return_at',
        'memo',
        'is_finished'
    ];

    //ソート用に使うカラムを指定
    public $sortable = [
        'project_num',
        'clientname',
        'keep_at',
        'return_at',
        'is_finished',
        'user_id'
    ];

    //relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // // プロジェクト№ハイフンつける

    //初期値設定
    // $input_projectnum = null;
    // $output_projectnum = null;

    // if(isset())
    // $input_postno = $_REQUEST["projectnumber"];

   	// /** 数字を半角に変換する */
	// $projectnum = mb_convert_kana($postno, "n");
 
	// /** 数字以外を削除する */
	// $projectnum = preg_replace("/[^0-9]/", "", $postno);


//アクセサを利用して預託データごとの返却期限までの残日数を算出
    public function getRemainingDaysAttribute()
    {
        $returnDate = new Carbon($this->return_at);
        $today = Carbon::today();
        return $today->diffInDays($returnDate,false);
    }
}
