<?php

namespace App\Http\Controllers;

use App\Verification;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.verifikasi.index');
            }
            return 'Error 403 : Forbidden access';
        }
        return redirect('login');
    }

    public function upload()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'mahasiswa') {
                $data = Verification::findOrFail(Session::get('nim'));
                return view('pages.verifikasi.upload', compact('data'));
            }

            return 'Error 403 : Forbidden access';
        }

        return redirect('login');
    }

    public function pembayaran(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ],
            [
                'file.required' => 'Wajib mengunggah file bukti pembayaran',
                'file.mimes' => 'Format file salah',
                'file.max' => 'File terlalu besar, maksimal 2MB'
            ]
        );

        $id = Session::get('nim');
        $data = Verification::findOrFail($id);
        if ($data->pembayaran != NULL) {
            $file = public_path('photo/verifications/pembayaran/' . $data->pembayaran);
            unlink($file);
        }
        $fileName = Str::replaceFirst('.', '', $id);
        $extension = $request->file->getClientOriginalExtension();
        $request->file->move(public_path('photo/verifications/pembayaran/'), $fileName . '.' . $extension);
        $data->pembayaran = $fileName . '.' . $extension;
        $data->status_pembayaran = 'pending';
        $data->save();

        $request->session()->flash('success', 'File berhasil diunggah');

        return redirect('upload');
    }

    public function lppm(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ],
            [
                'file.required' => 'Wajib mengunggah file bukti LPPM',
                'file.mimes' => 'Format file salah',
                'file.max' => 'File terlalu besar, maksimal 2MB'
            ]
        );

        $id = Session::get('nim');
        $data = Verification::findOrFail($id);
        if ($data->lppm != NULL) {
            $file = public_path('photo/verifications/lppm/' . $data->lppm);
            unlink($file);
        }
        $fileName = Str::replaceFirst('.', '', $id);
        $extension = $request->file->getClientOriginalExtension();
        $request->file->move(public_path('photo/verifications/lppm/'), $fileName . '.' . $extension);
        $data->lppm = $fileName . '.' . $extension;
        $data->status_lppm = 'pending';
        $data->save();

        $request->session()->flash('success', 'File berhasil diunggah');

        return redirect('upload');
    }

    public function perpus(Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
            ],
            [
                'file.required' => 'Wajib mengunggah file bukti perpustakaan',
                'file.mimes' => 'Format file salah',
                'file.max' => 'File terlalu besar, maksimal 2MB'
            ]
        );

        $id = Session::get('nim');
        $data = Verification::findOrFail($id);
        if ($data->perpus != NULL) {
            $file = public_path('photo/verifications/perpustakaan/' . $data->perpus);
            unlink($file);
        }
        $fileName = Str::replaceFirst('.', '', $id);
        $extension = $request->file->getClientOriginalExtension();
        $request->file->move(public_path('photo/verifications/perpustakaan/'), $fileName . '.' . $extension);
        $data->perpus = $fileName . '.' . $extension;
        $data->status_perpus = 'pending';
        $data->save();

        $request->session()->flash('success', 'File berhasil diunggah');

        return redirect('upload');
    }

    public function edit($id)
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                $data = Verification::join('students', 'students.nim', '=', 'verifications.nim')
                    ->select('students.*', 'verifications.*')
                    ->where('students.nim', $id)
                    ->first();
                return view('pages.verifikasi.verifikasi', compact('data'));
            }
            return 'Error 403 : Forbidden access';
        }

        return redirect('login');
    }

    public function verif(Request $request, $id)
    {
        $data = Verification::findOrFail($id);
        if ($request->field == 'pembayaran') {
            if ($request->type == 'verifikasi') {
                $data->status_pembayaran = 'approved';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti pembayaran telah anda setujui'
                ], 200);
            } elseif ($request->type == 'reject') {
                $data->status_pembayaran = 'rejected';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti pembayaran telah anda tolak'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request'
                ], 400);
            }
        } elseif ($request->field == 'lppm') {
            if ($request->type == 'verifikasi') {
                $data->status_lppm = 'approved';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti LPPM telah anda setujui'
                ], 200);
            } elseif ($request->type == 'reject') {
                $data->status_lppm = 'rejected';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti LPPM telah anda tolak'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request'
                ], 400);
            }
        } elseif ($request->field == 'perpus') {
            if ($request->type == 'verifikasi') {
                $data->status_perpus = 'approved';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti perpustakaan telah anda setujui'
                ], 200);
            } elseif ($request->type == 'reject') {
                $data->status_perpus = 'rejected';
                $data->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi bukti perpustakaan telah anda tolak'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request'
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request'
            ], 400);
        }
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Verification::join('students', 'students.nim', '=', 'verifications.nim')
                ->select('students.*', 'verifications.*')
                ->where('students.tahun', date('Y'))
                ->get();
            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    return view('pages.verifikasi.status_upload', [
                        'data' => $data
                    ]);
                })
                ->addColumn('verif', function ($data) {
                    return view('pages.verifikasi.status_verif', [
                        'data' => $data
                    ]);
                })
                ->addColumn('action', function ($data) {
                    return view('layouts._action_show_only', [
                        'data' => $data,
                        'url_show' => route('verifikasi.edit', $data->nim)
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'verif', 'action'])
                ->make(true);
        }

        return 'Error 403 : Forbidden access';
    }
}
