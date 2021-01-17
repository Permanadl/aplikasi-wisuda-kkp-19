<?php

namespace App\Exports;

use App\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

class StudentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
            ->join('graduations', 'students.tahun', '=', 'graduations.tahun')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY students.nim) AS number'),
                'departements.id_prodi',
                'students.nim',
                'students.nama_mhs',
                'students.tempat_lahir',
                'students.tgl_lahir',
                'students.jk',
                'graduations.tgl_wisuda',
                'graduations.angkatan',
                'graduations.tgl_yudisium'
            )
            ->where('students.tahun', $this->request)
            ->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE_PT',
            'ID_PRODI',
            'NIM',
            'NAMA',
            'TEMPAT_LAHIR',
            'TGL_LAHIR',
            'KELAMIN',
            'TANGGAL_WISUDA',
            'WISUDA_KE',
            'TGL_YUDISIUM'
        ];
    }

    public function map($students): array
    {
        return [
            $students->number,
            '',
            $students->id_prodi,
            $students->nim,
            $students->nama_mhs,
            $students->tempat_lahir,
            $students->tgl_lahir,
            $students->jk,
            $students->tgl_wisuda,
            $students->angkatan,
            $students->tgl_yudisium
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $count = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
                    ->join('graduations', 'students.tahun', '=', 'graduations.tahun')
                    ->select(
                        DB::raw('ROW_NUMBER() OVER (ORDER BY students.nim) AS number'),
                        'departements.id_prodi',
                        'students.nim',
                        'students.nama_mhs',
                        'students.tempat_lahir',
                        'students.tgl_lahir',
                        'students.jk',
                        'graduations.tgl_wisuda',
                        'graduations.angkatan',
                        'graduations.tgl_yudisium'
                    )
                    ->where('students.tahun', $this->request)
                    ->count();
                $count = $count + 1;
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                $event->sheet->getStyle('A1:K' . $count)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0000000']
                        ]
                    ]
                ]);
            }
        ];
    }
}
