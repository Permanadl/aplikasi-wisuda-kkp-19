<?php

namespace App\Http\Controllers;

use App\Departement;
use App\Student;
use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApiController extends Controller
{
    public function rank(Request $request)
    {
        $data = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
            ->select('students.*', 'departements.nama_prodi')
            ->orderBy('students.ipk', 'desc')
            ->where([
                ['departements.nama_prodi', 'like', '%' . $request->searchByProdi . '%'],
                ['students.tahun', 'like', '%' . $request->searchByYear . '%']
            ])
            ->limit(10)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function chartGrad()
    {
        $year = (int) date('Y');

        $nowYear = DB::table('students')
            ->where('tahun', $year)
            ->count();
        $beforeOne = DB::table('students')
            ->where('tahun', $year - 1)
            ->count();
        $beforeTwo = DB::table('students')
            ->where('tahun', $year - 2)
            ->count();
        $beforeThree = DB::table('students')
            ->where('tahun', $year - 3)
            ->count();
        $beforeFour = DB::table('students')
            ->where('tahun', $year - 4)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                0 => [
                    'tahun' => $year - 4,
                    'jumlah' => $beforeFour
                ],
                1 => [
                    'tahun' => $year - 3,
                    'jumlah' => $beforeThree
                ],
                2 => [
                    'tahun' => $year - 2,
                    'jumlah' => $beforeTwo
                ],
                3 => [
                    'tahun' => $year - 1,
                    'jumlah' => $beforeOne
                ],
                4 => [
                    'tahun' => $year,
                    'jumlah' => $nowYear
                ]
            ]
        ]);
    }

    public function counting()
    {
        $year = date('Y');
        /*Wisudawan*/
        $total = DB::table('students')
            ->count();
        $inYear = DB::table('students')
            ->where('tahun', $year)
            ->count();

        $data[] = number_format($total, 0, '', '.');
        $data[] = number_format($inYear, 0, '', '.');

        /*IPK*/
        $avgAll = DB::table('students')
            ->avg('ipk');
        $notInYear = DB::table('students')
            ->where('tahun', '<', $year)
            ->avg('ipk');

        $dev = $avgAll - $notInYear;

        $data[] = number_format($avgAll, 2, '.', '');
        $data[] = number_format(abs($dev), 2, '.', '');
        $data[] = $dev < 0 ? 'danger' : $dev == 0 ? 'muted' : 'success';

        /*Cumlaude*/
        $total = DB::table('students')
            ->where('ipk', '>=', '3.4')
            ->count();
        $inYear = DB::table('students')
            ->where('tahun', $year)
            ->where('ipk', '>=', '3.4')
            ->count();

        $data[] = number_format($total, 0, '', '.');
        $data[] = number_format($inYear, 0, '', '.');
        return response()->json([
            'success' => true,
            'message' => 'Menghitung jumlah row',
            'data' => [
                'lulusan' => [
                    'total' => $data[0],
                    'inyear' => $data[1]
                ],
                'ipk' => [
                    'ipk' => $data[2],
                    'margin' => $data[3],
                    'status' => $data[4]
                ],
                'cumlaude' => [
                    'total' => $data[5],
                    'inyear' => $data[6]
                ]
            ]
        ], 200);
    }

    public function wisudawan()
    {
        $data = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
            ->select('students.nim', 'students.nama_mhs', 'students.tahun', 'students.photo', 'departements.nama_prodi')
            ->get();
        return DataTables::of($data)
            ->addColumn('img', function ($data) {
                $img = $data->photo == NULL ? 'default.jpg' : $data->photo;
                return '<img src="' . asset("photo/students/" . $img) . '" alt="profile image">';
            })
            ->addColumn('link', function ($data) {
                return '<a href="' . route('profilWisudawan', $data->nim) . '">' . $data->nama_mhs . '</a>';
            })
            ->addIndexColumn()
            ->rawColumns(['img', 'link'])
            ->make(true);
    }

    public function ipk()
    {
        $year = (int) date('Y');

        $nowYear = DB::table('students')
            ->where('tahun', $year)
            ->avg('ipk');
        $nowYear = number_format($nowYear, '2', '.', '');
        $beforeOne = DB::table('students')
            ->where('tahun', $year - 1)
            ->avg('ipk');
        $beforeOne = number_format($beforeOne, '2', '.', '');
        $beforeTwo = DB::table('students')
            ->where('tahun', $year - 2)
            ->avg('ipk');
        $beforeTwo = number_format($beforeTwo, '2', '.', '');
        $beforeThree = DB::table('students')
            ->where('tahun', $year - 3)
            ->avg('ipk');
        $beforeThree = number_format($beforeThree, '2', '.', '');
        $beforeFour = DB::table('students')
            ->where('tahun', $year - 4)
            ->avg('ipk');
        $beforeFour = number_format($beforeFour, '2', '.', '');

        return response()->json([
            'success' => true,
            'data' => [
                0 => [
                    'tahun' => $year - 4,
                    'ipk' => $beforeFour
                ],
                1 => [
                    'tahun' => $year - 3,
                    'ipk' => $beforeThree
                ],
                2 => [
                    'tahun' => $year - 2,
                    'ipk' => $beforeTwo
                ],
                3 => [
                    'tahun' => $year - 1,
                    'ipk' => $beforeOne
                ],
                4 => [
                    'tahun' => $year,
                    'ipk' => $nowYear
                ]
            ]
        ]);
    }

    public function gradPerProdi()
    {
        $year = (int) date('Y');
        $query = Departement::all();

        $nowYear = [];
        foreach ($query as $item) {
            $subquery = Student::where('tahun', $year)
                ->where('id_prodi', $item->id_prodi)
                ->count();
            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'jumlah' => $subquery
            ];

            array_push($nowYear, $push);
        }

        $beforeOne = [];
        foreach ($query as $item) {
            $subquery = Student::where('tahun', $year - 1)
                ->where('id_prodi', $item->id_prodi)
                ->count();
            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'jumlah' => $subquery
            ];

            array_push($beforeOne, $push);
        }

        $beforeTwo = [];
        foreach ($query as $item) {
            $subquery = Student::where('tahun', $year - 2)
                ->where('id_prodi', $item->id_prodi)
                ->count();
            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'jumlah' => $subquery
            ];

            array_push($beforeTwo, $push);
        }

        $beforeThree = [];
        foreach ($query as $item) {
            $subquery = Student::where('tahun', $year - 3)
                ->where('id_prodi', $item->id_prodi)
                ->count();
            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'jumlah' => $subquery
            ];

            array_push($beforeThree, $push);
        }

        $beforeFour = [];
        foreach ($query as $item) {
            $subquery = Student::where('tahun', $year - 2)
                ->where('id_prodi', $item->id_prodi)
                ->count();
            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'jumlah' => $subquery
            ];

            array_push($beforeFour, $push);
        }

        return response()->json([
            'success' => true,
            'data' => [
                0 => [
                    'tahun' => $year - 4,
                    'data' => $beforeFour
                ],
                1 => [
                    'tahun' => $year - 3,
                    'data' => $beforeThree
                ],
                2 => [
                    'tahun' => $year - 2,
                    'data' => $beforeTwo
                ],
                3 => [
                    'tahun' => $year - 1,
                    'data' => $beforeOne
                ],
                4 => [
                    'tahun' => $year,
                    'data' => $nowYear
                ]
            ]
        ]);
    }

    public function perProdi()
    {
        $data = [];
        $prodi = Departement::all();
        foreach ($prodi as $item) {
            $total = Student::where('id_prodi', $item->id_prodi)->count();
            $inYear = Student::where('id_prodi', $item->id_prodi)
                ->where('tahun', date('Y'))
                ->count();

            $push = [
                'id_prodi' => $item->id_prodi,
                'nama_prodi' => $item->nama_prodi,
                'total' => $total,
                'inyear' => $inYear
            ];
            array_push($data, $push);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function testi(Request $request)
    {
        $data = [];
        $testi = Testimonial::join('students', 'testimonials.nim', 'students.nim')
            ->join('departements', 'students.id_prodi', 'departements.id_prodi')
            ->orderBy('students.tahun', 'desc')
            ->where([
                ['students.nama_mhs', 'like', '%' . $request->name . '%'],
                ['departements.nama_prodi', 'like', '%' . $request->prodi . '%']
            ])
            ->get();
        foreach ($testi as $item) {
            $photo = $item->photo == NULL ? 'default.jpg' : $item->photo;
            $push = [
                'id' => $item->id,
                'nama_mhs' => $item->nama_mhs,
                'rating' => $item->rating,
                'testi' => $item->testimoni,
                'photo' => $photo,
                'nama_prodi' => $item->nama_prodi,
                'request' => $request->name
            ];

            array_push($data, $push);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
