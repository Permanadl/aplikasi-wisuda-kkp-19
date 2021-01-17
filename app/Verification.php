<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $primaryKey = 'nim';

    public $incrementing = false;
    public $timestamps = false;
}
