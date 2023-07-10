<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationType extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->hasmany(Client::class);
    }
}
