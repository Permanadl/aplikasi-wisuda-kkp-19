<?php

namespace App\Http\Controllers;

use App\Student;
use App\Departement;
use App\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $tahun = Student::select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();
        $prodi = Departement::all();
        $limit = 5;
        $testi = Testimonial::join('students', 'students.nim', '=', 'testimonials.nim')
            ->select('students.*', 'testimonials.*')
            ->orderBy('testimonials.rating', 'desc')
            ->limit($limit)
            ->get();
        $count = Testimonial::join('students', 'students.nim', '=', 'testimonials.nim')
            ->select('students.*', 'testimonials.*')
            ->orderBy('testimonials.rating', 'desc')
            ->count();
        if ($count >= $limit) {
            $thumb['left'] = $limit;
            $thumb['right'] = 1;
            $status = 'first';
        } elseif ($count > 2) {
            $thumb['left'] = $count - 1;
            $thumb['right'] = 1;
            $status = 'second';
        } elseif ($count > 1) {
            $thumb['left'] = 1;
            $thumb['right'] = 1;
            $status = 'third';
        } else {
            $thumb['left'] = 0;
            $thumb['right'] = 0;
            $status = 'fourth';
        }
        return view('index', compact('tahun', 'prodi', 'testi', 'thumb', 'status'));
    }

    public function wisudawan()
    {
        return view('wisudawan');
    }

    public function statistik()
    {
        $data['l'] = Student::where('jk', 'L')->count();
        $data['p'] = Student::where('jk', 'P')->count();
        return view('statistik', compact('data'));
    }

    public function testimoni()
    {
        $data = Departement::all();
        return view('testimoni', compact('data'));
    }

    public function profil($id)
    {
        $data = Student::join('departements', 'students.id_prodi', '=', 'departements.id_prodi')
            ->select(
                'students.nim',
                'students.nama_mhs',
                'students.tahun',
                'students.photo',
                'students.jk',
                'students.tempat_lahir',
                'students.tgl_lahir',
                'students.email',
                'students.no_hp',
                'students.judul_skripsi',
                'students.alamat',
                'students.ipk',
                'departements.nama_prodi'
            )
            ->where('students.nim', $id)
            ->first();
        return view('detail', compact('data'));
    }
}
