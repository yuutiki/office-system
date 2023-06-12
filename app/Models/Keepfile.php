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

    // $input_projectum = null;
    // $output_projectum = null;

    // $input_postno = $_REQUEST["projectnumber"];

   	// /** 数字を半角に変換する */
	// $projectnum = mb_convert_kana($postno, "n");
 
	// /** 数字以外を削除する */
	// $projectnum = preg_replace("/[^0-9]/", "", $postno);


    public static function Remaining()
    {
        $keepfiles = Keepfile::get();
        $today = today();

        foreach($keepfiles as $keepfile)
        {
            $return_at = $keepfile->return_at;
        }
        $carbonReturn_at = new Carbon($return_at);
        $dt = $today->diffIndays($carbonReturn_at);
        return $dt;

    }
}
