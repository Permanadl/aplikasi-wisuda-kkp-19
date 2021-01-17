<?php

namespace App\Http\Controllers;

use App\Graduation;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GraduationController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.wisuda.index');
            }

            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function create()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = new Graduation();
                return view('pages.wisuda.form', compact('data'));
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
                'tahun' => 'required|unique:graduations|numeric|digits:4',
                'angkatan' => 'required|unique:graduations|numeric',
                'tgl_wisuda' => 'required|date',
                'tgl_yudisium' => 'required|date',
                'tempat' => 'required|string|max:100'
            ],
            [
                'angkatan.required' => 'Kolom angkatan wajib diisi',
                'angkatan.numeric' => 'Harus diisi dengan angka',
                'angkatan.unique' => 'Tidak boleh ada angkatan yang sama',
                'tahun.required' => 'Kolom tahun wajib diisi',
                'tahun.numeric' => 'Hanya boleh diisi angka',
                'tahun.digits' => 'Harus terdiri dari 4 angka',
                'tahun.unique' => 'Tidak boleh ada tahun yang sama',
                'tgl_wisuda.required' => 'Kolom tanggal wisuda wajib diisi',
                'tgl_yudisium.required' => 'Kolom tanggal yudisium wajib diisi',
                'tempat.required' => 'Kolom tempat wajib diisi',
                'tempat.max' => 'Maksimal 100 karakter'
            ]
        );

        $data = Graduation::insert([
            [
                'tahun' => $request->tahun,
                'angkatan' => $request->angkatan,
                'tgl_wisuda' => $request->tgl_wisuda,
                'tgl_yudisium' => $request->tgl_yudisium,
                'tempat' => $request->tempat
            ]
        ]);
        return $data;
    }

    public function edit($id)
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Graduation::findOrFail($id);
                return view('pages.wisuda.form', compact('data'));
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
                'tgl_wisuda' => 'required|date',
                'tgl_yudisium' => 'required|date',
                'tempat' => 'required|string|max:100'
            ],
            [
                'tgl_wisuda.required' => 'Kolom tanggal wisuda wajib diisi',
                'tgl_yudisium.required' => 'Kolom tanggal yudisium wajib diisi',
                'tempat.required' => 'Kolom tempat wajib diisi',
                'tempat.max' => 'Maksimal 100 karakter'
            ]
        );

        $data = Graduation::findOrFail($id);
        $data->tgl_wisuda = $request->tgl_wisuda;
        $data->tgl_yudisium = $request->tgl_yudisium;
        $data->tempat = $request->tempat;
        $data->save();
    }

    public function destroy($id)
    {
        $data = Graduation::findOrFail($id);
        $data->delete();
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Graduation::query();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('layouts._standar_action', [
                        'data' => $data,
                        'url_edit' => route('wisuda.edit', $data->tahun),
                        'url_destroy' => route('wisuda.destroy', $data->tahun),
                        'title' => $data->angkatan
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return 'Error 403 : Forbidden access';
    }
}
