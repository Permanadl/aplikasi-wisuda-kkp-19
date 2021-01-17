<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            $data = DB::table('departements')->get();
            return view('pages.dashboard', compact('data'));
        }
        return redirect('login');
    }

    public function counting()
    {
        if (Session::has('login')) {
            $year = date('Y');
            /*Wisudawan*/
            $nowYear = DB::table('students')
                ->where('tahun', $year)
                ->count();
            $lastYear = DB::table('students')
                ->where('tahun', $year - 1)
                ->count();

            $dev = $nowYear - $lastYear;
            $ratio = $lastYear == 0 ? $nowYear : (abs($dev) / $lastYear);
            $ratio = $ratio * 100;

            $data[] = $nowYear;
            $data[] = is_int($ratio) ? $ratio : number_format($ratio, 2, '.', '');
            $data[] = $dev < 0 ? 'danger' : 'success';

            /*Verifikasi*/
            $hasVerif = DB::table('students')
                ->join('verifications', 'students.nim', '=', 'verifications.nim')
                ->where([
                    ['students.tahun', $year],
                    ['verifications.status_pembayaran', 'approved'],
                    ['verifications.status_lppm', 'approved'],
                    ['verifications.status_perpus', 'approved']
                ])
                ->count();
            $allStudents = DB::table('students')
                ->where('tahun', $year)
                ->count();

            $ratio = $hasVerif / $allStudents;
            $ratio = $ratio * 100;

            $data[] = $hasVerif;
            $data[] = is_int($ratio) ? $ratio : number_format($ratio, 1, '.', '');
            if ($ratio == 100) {
                $data[] = 'success';
            } elseif ($ratio < 100 && $ratio > 49) {
                $data[] = 'warning';
            } else {
                $data[] = 'danger';
            }

            /*IPK*/
            $nowIpk = DB::table('students')
                ->where('tahun', $year)
                ->avg('ipk');
            $lastIpk = DB::table('students')
                ->where('tahun', $year - 1)
                ->avg('ipk');

            $dev = $nowIpk - $lastIpk;

            $data[] = number_format($nowIpk, 2, '.', '');
            $data[] = number_format($dev, 2, '.', '');
            $data[] = $dev < 0 ? 'danger' : 'success';

            /*Testimoni*/
            $data[] = DB::table('testimonials')->count();
            return response()->json([
                'success' => true,
                'message' => 'Menghitung jumlah row',
                'data' => [
                    'wisudawan' => [
                        'jumlah' => $data[0],
                        'rasio' => $data[1],
                        'status' => $data[2]
                    ],
                    'verifikasi' => [
                        'jumlah' => $data[3],
                        'rasio' => $data[4],
                        'status' => $data[5]
                    ],
                    'ipk' => [
                        'ipk' => $data[6],
                        'rasio' => $data[7],
                        'status' => $data[8]
                    ],
                    'testi' => [
                        'jumlah' => $data[9]
                    ]
                ]
            ], 200);
        }
        return 'Error 403: Forbidden access';
    }

    public function rank(Request $request)
    {
        if (Session::has('login') && Session::get('level') == 'admin') {

            $data = DB::table('students')
                ->select('nim', 'nama_mhs', 'ipk')
                ->orderBy('ipk', 'desc')
                ->limit(10)
                ->where([
                    ['id_prodi', 'like', '%' . $request->searchByProdi . '%'],
                    ['tahun', '=', date('Y')]
                ])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return 'Error 403 : Forbidden access';
    }

    public function chartGrad()
    {
        if (Session::has('login')) {
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

        return 'Error 403 : Forbidden access';
    }

    public function chartIpk()
    {
        if (Session::has('login')) {
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
        return 'Error 403 : Forbidde access';
    }

    public function chartProdi()
    {
        if (Session::has('login')) {
            $year = date('Y');
            $prodi = DB::table('departements')->select('id_prodi', 'nama_prodi')->get();
            compact('prodi');

            foreach ($prodi as $p) {
                $grad = DB::table('students')
                    ->join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
                    ->where('students.id_prodi', $p->id_prodi)
                    ->count();
                $count[] = $grad;
            }

            return response()->json([
                'prodi' => $prodi,
                'grad' => $count
            ]);
        }

        return 'Error 403 : Forbidden access';
    }
}
