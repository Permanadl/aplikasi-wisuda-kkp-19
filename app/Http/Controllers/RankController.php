<?php

namespace App\Http\Controllers;

use App\Student;
use App\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class RankController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Departement::all();
                return view('pages.peringkat.index', compact('data'));
            }
            return 'Error 403 : Forbidden access';
        }

        return redirect('login');
    }

    public function dataTables(Request $request)
    {
        if (Session::has('login') && Session::get('level') == 'admin') {

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
                ->addColumn('action', function ($data) {
                    return view('layouts._action_with_show', [
                        'data' => $data,
                        'url_show' => route('wisudawan.show', $data->nim),
                        'url_edit' => route('wisudawan.edit', $data->nim),
                        'url_destroy' => route('wisudawan.destroy', $data->nim),
                        'title' => $data->nama_mhs
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return 'Error 403 : Forbidden access';
    }
}
