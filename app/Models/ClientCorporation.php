<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add
use Illuminate\Support\Facades\DB;//add


class ClientCorporation extends Model
{
    use HasFactory;
    use Sortable;//add

    protected $fillable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name',
    ];

    public $sortable = [
        'clientcorporation_num',
        'clientcorporation_name',
        'clientcorporation_kana_name'
    ];

    public function storeWithTransaction($data)
    {
        //DB::transactionメソッドを使用してトランザクションを開始
        return DB::transaction(function () use ($data)
        {
            //本メソッド内で法人情報を作成し、法人番号を採番
            $lastCorporation = ClientCorporation::orderBy('id', 'desc')->first();
            $lastNumber = $lastCorporation ? $lastCorporation->clientcorporation_num : '000000';
            $newNumber = str_pad((int) $lastNumber + 1, 6, '0', STR_PAD_LEFT);

            $data['clientcorporation_num'] = $newNumber;
            $corporation = ClientCorporation::create($data);

            if ($corporation)
            {
                return true;
            }
            else
            {
                return false;
            }

        });

    }
    

        //relation
        public function clients()
        {
            return $this->belongsToMany(client::class);
        }
    
        // public function employee_status()
        // {
        //     return $this->belongsTo(Employee_status::class);
        // }
    
        // public function keepfiles()
        // {
        //     return $this->belongsToMany(Keepfile::class);
        // }
}
