<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrator;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            return redirect('dashboard');
        }
        return view('pages.login');
    }

    public function admin_auth(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $data = Administrator::where('username', $username)->first();
        if ($data) {
            if (Hash::check($password, $data->password)) {
                $data->last_login = now();
                $data->save();
                Session::put('nama', $data->nama_admin);
                Session::put('level', 'admin');
                Session::put('edited', '');
                Session::put('login', TRUE);
                return response()->json([
                    'success' => true
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi anda salah!'
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nama pengguna tidak terdaftar!'
            ], 401);
        }
    }

    public function student_auth(Request $request)
    {
        $nim = $request->input('nim');
        $password = $request->input('password');

        $data = Student::where('nim', $nim)->first();
        if ($data) {
            if (Hash::check($password, $data->password)) {
                $data->last_login = now();
                $data->save();
                Session::put('nim', $data->nim);
                Session::put('nama', $data->nama_mhs);
                Session::put('edited', $data->edited);
                Session::put('level', 'mahasiswa');
                Session::put('login', TRUE);
                return response()->json([
                    'success' => true
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi anda salah!'
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak terdaftar!'
            ], 401);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }
}
