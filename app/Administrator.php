<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $fillable = [
        'nama_admin', 'username', 'password', 'last_login'
    ];
}
