<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;//add

class Link extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = ['display_name', 'display_order', 'url', 'department_id'];


    //sort
    public $sortable = [
        'display_name',
        'url',
        'display_order',
        'department_name'
    ];

    //relation
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
