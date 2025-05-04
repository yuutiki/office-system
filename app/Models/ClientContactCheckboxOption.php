<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContactCheckboxOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'label', 'is_active', 'display_order'
    ];
    
    public function clientContacts()
    {
        return $this->belongsToMany(ClientContact::class, 'client_contact_checkbox_values', 'checkbox_option_id', 'client_contact_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
