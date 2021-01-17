<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable = [
        'id_prodi', 'nama_prodi', 'jenjang'
    ];
    protected $primaryKey = 'id_prodi';
}
