<?php

namespace App\Http\Controllers;

use App\Departement;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepartementController extends Controller
{

    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.prodi.index');
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function create()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = new Departement();
                return view('pages.prodi.form', compact('data'));
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_prodi' => 'required|string|digits:5',
                'nama_prodi' => 'required',
                'jenjang' => 'required'
            ],
            [
                'id_prodi.required' => 'Kolom kode prodi wajib diisi',
                'id_prodi.digits' => 'Harus terdiri dari 5 karakter',
                'nama_prodi.required' => 'Kolom nama prodi wajib diisi',
                'jenjang.required' => 'Wajib memilih jenjang'
            ]
        );

        $data = Departement::insert([
            [
                'id_prodi' => $request->id_prodi,
                'nama_prodi' => $request->nama_prodi,
                'jenjang' => $request->jenjang,
                'created_at' => now()
            ]
        ]);
        return $data;
    }

    public function edit($id)
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Departement::findOrFail($id);
                return view('pages.prodi.form', compact('data'));
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'id_prodi' => 'required|string|digits:5',
                'nama_prodi' => 'required',
                'jenjang' => 'required'
            ],
            [
                'id_prodi.required' => 'Kolom kode prodi wajib diisi',
                'id_prodi.digits' => 'Harus terdiri dari 5 karakter',
                'nama_prodi.required' => 'Kolom nama prodi wajib diisi',
                'jenjang.required' => 'Wajib memilih jenjang'
            ]
        );

        $data = Departement::findOrFail($id);
        $data->nama_prodi = $request->nama_prodi;
        $data->jenjang = $request->jenjang;
        $data->updated_at = now();
        $data->save();
    }

    public function destroy($id)
    {
        $data = Departement::findOrFail($id);
        $data->delete();
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Departement::query();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('layouts._standar_action', [
                        'data' => $data,
                        'url_edit' => route('prodi.edit', $data->id_prodi),
                        'url_destroy' => route('prodi.destroy', $data->id_prodi),
                        'title' => $data->nama_prodi
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return 'Error 403 : Forbidden access';
    }
}
