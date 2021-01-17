<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class StudentsImport implements ToModel, WithStartRow, SkipsOnError, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'nim' => $row[0],
            'nama_mhs' => $row[1],
            'jk' => $row[2],
            'id_prodi' => $row[3],
            'tahun' => $row[4],
            'ipk' => $row[5],
            'judul_skripsi' => $row[6],
            'password' => bcrypt($row[0] . '*Aa'),
            'created_at' => now()
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '*.0' => ['required', 'unique:students,nim']
        ];
    }

    public function onError(Throwable $e)
    {
    }
}
