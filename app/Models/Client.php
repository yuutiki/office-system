<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_num',
        'client_name',
        'client_kana_name',
        'clientcorporation_num',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->client_num = $model->generateClientNumber();
        });
    }

    public function generateClientNumber()
    {
        $corporationNumber = $this->clientcorporation->clientcorporation_num;
        $latestClient = $this->clientcorporation->clients()->latest()->first();

        if ($latestClient) {
            $latestNumber = substr($latestClient->client_num, -2);
            $nextNumber = str_pad((int)$latestNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '01';
        }

        return $corporationNumber . '-' . $nextNumber;
    }

    //relation
    public function clientcorporation()
    {
        return $this->belongsTo(ClientCorporation::class);
    }
}
