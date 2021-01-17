<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
    protected $fillable = [
        'angkatan', 'tahun', 'tgl_wisuda', 'tgl_yudisium', 'tempat'
    ];

    protected $primaryKey = 'tahun';

    public $timestamps = false;
}
