<?php

namespace App\Http\Controllers;

use App\Student;
use App\Imports\StudentsImport;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.wisudawan.index');
            }
            return 'Error 403 : Forbidden access';
        } else {
            return redirect('login');
        }
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new StudentsImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            $request->session()->flash('success', 'Data Berhasil Diimport!');
            return redirect()->route('wisudawan.index');
        } else {
            //redirect
            $request->session()->flash('error', 'Data Gagal Diimport. Mohon periksa kembali file anda!');
            return redirect()->route('wisudawan.index');
        }
    }

    public function download()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.lldikti.index');
            }

            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function export(Request $request)
    {
        return Excel::download(new StudentsExport($request->tahun), 'student.xlsx');
    }

    public function create()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = new Student();
                $prodi = DB::table('departements')->get();
                $selectProdi = [];
                foreach ($prodi as $prodi) {
                    $selectProdi[$prodi->id_prodi] = $prodi->nama_prodi;
                }

                return view('pages.wisudawan.form', compact('data', 'selectProdi'));
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
                'nim' => 'required|string|size:10',
                'nama_mhs' => 'required',
                'jk' => 'required',
                'id_prodi' => 'required',
                'judul_skripsi' => 'required',
                'ipk' => 'required'
            ],
            [
                'nim.required' => 'Kolom NIM wajib diisi',
                'nim.size' => 'Harus terdiri dari 10 karakter',
                'nama_mhs.required' => 'Kolom nama wisudawan wajib diisi',
                'jk.required' => 'Wajib memilih jenis kelamin',
                'id_prodi.required' => 'Wajib memilih prodi',
                'judul_skripsi.required' => 'Kolom judul skripsi wajib diisi',
                'ipk.required' => 'Kolom IPK wajib diisi'
            ]
        );

        $data = Student::insert([
            [
                'nim' => $request->nim,
                'nama_mhs' => $request->nama_mhs,
                'jk' => $request->jk,
                'id_prodi' => $request->id_prodi,
                'ipk' => $request->ipk,
                'tahun' => date('Y'),
                'judul_skripsi' => $request->judul_skripsi,
                'password' => bcrypt($request->nim . '*Aa'),
                'created_at' => now()
            ]
        ]);
        return $data;
    }

    public function show($id)
    {
        $data = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
            ->select('students.*', 'departements.nama_prodi')
            ->where('students.nim', $id)
            ->first();

        return view('pages.wisudawan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Student::findOrFail($id);
        $prodi = DB::table('departements')->get();
        $selectProdi = [];
        foreach ($prodi as $prodi) {
            $selectProdi[$prodi->id_prodi] = $prodi->nama_prodi;
        }
        return view('pages.wisudawan.form', compact('data', 'selectProdi'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'nim' => 'required|string|size:10',
                'nama_mhs' => 'required',
                'jk' => 'required',
                'id_prodi' => 'required',
                'judul_skripsi' => 'required',
                'ipk' => 'required'
            ],
            [
                'nim.required' => 'Kolom NIM wajib diisi',
                'nim.size' => 'Harus terdiri dari 10 karakter',
                'nama_mhs.required' => 'Kolom nama wisudawan wajib diisi',
                'jk.required' => 'Wajib memilih jenis kelamin',
                'id_prodi.required' => 'Wajib memilih prodi',
                'judul_skripsi.required' => 'Kolom judul skripsi wajib diisi',
                'ipk.required' => 'Kolom IPK wajib diisi'
            ]
        );

        $data = Student::findOrFail($id);
        $data->nama_mhs = $request->nama_mhs;
        $data->jk = $request->jk;
        $data->id_prodi = $request->id_prodi;
        $data->judul_skripsi = $request->judul_skripsi;
        $data->ipk = $request->ipk;
        if (isset($request->reset)) {
            $data->password = bcrypt($id . '*Aa');
        }
        $data->updated_at = now();
        $data->save();
    }

    public function profile()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'mahasiswa') {
                $data = Student::join('graduations', 'graduations.tahun', 'students.tahun')
                    ->where('students.nim', Session::get('nim'))
                    ->first();
                return view('pages.wisudawan.profile', compact('data'));
            }

            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function updateProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'nama_mhs' => 'required|string|max:50',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'no_hp' => 'required',
                'email' => 'required|email',
                'alamat' => 'required'
            ],
            [
                'nama_mhs.required' => 'Nama wisudawan tidak boleh kosong',
                'nama_mhs.max' => 'Maksimal 50 karakter',
                'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong',
                'tgl_lahir.required' => 'Tanggal lahir tidak boleh kosong',
                'no_hp.required' => 'No handphone tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Alamat email tidak valid',
                'alamat.required' => 'Alamat tidak boleh kosong',
            ]
        );

        $id = Session::get('nim');
        Session::put('edited', 'edited');
        $data = Student::findOrFail($id);
        $data->nama_mhs = $request->nama_mhs;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->edited = 'edited';
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui'
        ]);
    }

    public function unggahPhoto(Request $request)
    {
        $this->validate(
            $request,
            [
                'photo' => 'required|image|mimes:jpeg,jpg|max:2048'
            ],
            [
                'photo.required' => 'Wajib mengunggah file photo',
                'photo.mimes' => 'Format file salah',
                'photo.max' => 'File terlalu besar, maksimal 2MB'
            ]
        );

        $id = Session::get('nim');
        $data = Student::findOrFail($id);
        if ($data->photo != NULL) {
            $file = public_path('photo/students/' . $data->photo);
            unlink($file);
        }
        $fileName = Str::replaceFirst('.', '', $id);
        $extension = $request->photo->getClientOriginalExtension();
        $request->photo->move(public_path('photo/students/'), $fileName . '.' . $extension);
        $data->photo = $fileName . '.' . $extension;
        $data->save();

        $request->session()->flash('success', 'Photo berhasil diunggah');

        return redirect('profile');
    }

    public function destroy($id)
    {
        $data = Student::findOrFail($id);
        if ($data->photo != NULL) {
            $file = public_path('photo/students/' . $data->photo);
            unlink($file);
        }
        $data->delete();
    }

    /*
    public function reset()
    {
        if (Session::has('login')) {
            $data = Student::findOrFail(Session::get('nim'));
            return view('pages.wisudawan.setting', compact('data'));
        }
        return redirect('login');
    }
    */

    public function doReset(Request $request)
    {
        $this->validate(
            $request,
            [
                'current_pass' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'current_pass.required' => 'Harus mengisi kata sandi sebelumnya',
                'password.required' => 'Harus mengisi kata sandi baru',
                'password.min' => 'Kata sandi minimal 8 karakter',
                'password.confirmed' => 'Kata sandi tidak cocok',
                'password_confirmation.required' => 'Konfirmasi kata sandi tidak boleh kosong'
            ]
        );
        $data = Student::where('nim', Session::get('nim'))->first();
        if (Hash::check($request->current_pass, $data->password)) {
            $query = Student::findOrFail($data->nim);
            $query->password = bcrypt($request->password);
            $query->save();

            return response()->json([
                'success' => true,
                'message' => 'Kata sandi berhasil diubah'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi sebelumnya tidak sesuai'
            ], 200);
        }
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
                ->select('students.*', 'departements.nama_prodi')
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
