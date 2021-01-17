<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    public function index()
    {
        if (Session::has('login')) {
            if (Session::get('level') == 'admin') {
                return view('pages.testimonial.index');
            } else {
                $cek = Testimonial::where('nim', Session::get('nim'))->count();
                if ($cek > 0) {
                    $data = Testimonial::where('nim', Session::get('nim'))->first();
                } else {
                    $data = NULL;
                }
                return view('pages.testimonial.form', compact('data'));
            }
        }
        return redirect('login');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'rating' => 'required',
                'testi' => 'required'
            ],
            [
                'rating.required' => 'Harus memilih rating',
                'testi.required' => 'Harus mengisi kesan'
            ]
        );

        Testimonial::insert([
            [
                'nim' => Session::get('nim'),
                'rating' => $request->rating,
                'testimoni' => $request->testi
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kesan berhasil dikirim'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'rating' => 'required',
                'testi' => 'required'
            ],
            [
                'rating.required' => 'Harus memilih rating',
                'testi.required' => 'Harus mengisi kesan'
            ]
        );

        Testimonial::where('nim', $id)
            ->update([
                'testimoni' => $request->testi,
                'rating' => $request->rating
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengirim perubahan'
        ]);
    }

    public function destroy($id)
    {
        $data = Testimonial::findOrFail($id);
        $data->delete();
    }

    public function dataTables()
    {
        if (Session::has('login') && Session::get('level') == 'admin') {
            $data = Testimonial::join('students', 'students.nim', '=', 'testimonials.nim')
                ->join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
                ->select('students.*', 'testimonials.*', 'departements.nama_prodi')
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return view('layouts._action_delete_only', [
                        'data' => $data,
                        'url_destroy' => route('testi.destroy', $data->id),
                        'title' => $data->nama_mhs
                    ]);
                })
                ->addColumn('rating', function ($data) {
                    return view('layouts._rating', [
                        'rate' => $data->rating
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'rating'])
                ->make(true);
        }
        return 'Error 403 : Forbidden access';
    }
}
