<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nim',
        'nama_mhs',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'id_prodi',
        'tahun',
        'email',
        'no_hp',
        'alamat',
        'photo',
        'ipk',
        'judul_skripsi',
        'password',
    ];
    protected $primaryKey = 'nim';
    public $incrementing = false;
}
