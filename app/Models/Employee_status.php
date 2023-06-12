<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee_status extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_status_num',
        'employee_status_name'
    ];

    public function users()
    {
        return $this->hasmany(User::class);
        // return $this->hasmany('App\Models\User','employee_status','employee_status_id');
    }
}
