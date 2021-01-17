<?php

namespace App\Http\Controllers;

use App\Administrator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class AdministratorController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.admin.index');
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function create()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = new Administrator();
                return view('pages.admin.form', compact('data'));
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
                'nama_admin' => 'required|string|max:30',
                'username' => 'required|string|max:20|unique:administrators,username',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string'
            ],
            [
                'nama_admin.required' => 'Kolom nama wajib diisi',
                'nama_admin.max' => 'Maksimal 30 karakter',
                'username.required' => 'Kolom nama pengguna wajib diisi',
                'username.max' => 'Maksimal 20 karakter',
                'username.unique' => 'Nama pengguna tidak tersedia',
                'password.required' => 'Kolom kata sandi wajib diisi',
                'password.min' => 'Minimal 8 karakter',
                'password.confirmed' => 'Kata sandi tidak cocok',
                'password_confirmation.required' => 'Kolom konfirmasi wajib diisi'
            ]
        );

        $data = Administrator::insert([
            [
                'nama_admin' => $request->nama_admin,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'created_at' => now()
            ]
        ]);
        return $data;
    }

    public function edit($id)
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Administrator::findOrFail($id);
                return view('pages.admin.form', compact('data'));
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
                'nama_admin' => 'required|string|max:30',
                'username' => 'required|string|max:20|unique:administrators,username,' . $id
            ],
            [
                'nama_admin.required' => 'Kolom nama wajib diisi',
                'nama_admin.max' => 'Maksimal 30 karakter',
                'username.required' => 'Kolom nama pengguna wajib diisi',
                'username.max' => 'Maksimal 20 karakter',
                'username.unique' => 'Nama pengguna tidak tersedia'
            ]
        );

        $data = Administrator::findOrFail($id);
        $data->nama_admin = $request->nama_admin;
        $data->username = $request->username;
        $data->updated_at = now();
        $data->save();
    }

    public function reset($id)
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Administrator::findOrFail($id);
                return view('pages.admin.reset', compact('data'));
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function doReset(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|string|max:20|unique:administrators,username,' . $id,
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string'
            ],
            [
                'username.required' => 'Kolom nama pengguna wajib diisi',
                'username.max' => 'Maksimal 20 karakter',
                'username.unique' => 'Nama pengguna tidak tersedia',
                'password.required' => 'Kolom kata sandi wajib diisi',
                'password.min' => 'Minimal 8 karakter',
                'password.confirmed' => 'Kata sandi tidak cocok',
                'password_confirmation.required' => 'Kolom konfirmasi wajib diisi'
            ]
        );

        $data = Administrator::findOrFail($id);
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->updated_at = now();
        $data->save();
    }

    public function destroy($id)
    {
        $data = Administrator::findOrFail($id);
        $data->delete();
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Administrator::query();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('layouts._action_with_reset', [
                        'data' => $data,
                        'url_reset' => route('admin.reset', $data->id),
                        'url_edit' => route('admin.edit', $data->id),
                        'url_destroy' => route('admin.destroy', $data->id),
                        'title' => $data->nama_admin
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return 'Error 403 : Forbidden access';
    }
}
