<?php

use App\Student;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

/* START ROUTE FRONT */

Route::get('/', 'HomeController@index')->name('home');
Route::get('/list-wisudawan', 'HomeController@wisudawan')->name('listWisudawan');
Route::get('/statistik', 'HomeController@statistik')->name('statistik');
Route::get('/testimonial', 'HomeController@testimoni')->name('testimoni');
Route::get('/profil-wisudawan/{id}', 'HomeController@profil')->name('profilWisudawan');

Route::post('/api/frontRank', 'ApiController@rank')->name('front.rank');
Route::get('/api/frontGrad', 'ApiController@chartGrad')->name('front.grad');
Route::get('/api/frontCounting', 'ApiController@counting')->name('front.counting');
Route::get('/api/frontWisudawan', 'ApiController@wisudawan')->name('front.wisudawan');
Route::get('/api/frontIpk', 'ApiController@ipk')->name('front.ipk');
Route::get('/api/frontProdi', 'ApiController@gradPerProdi')->name('front.prodi');
Route::get('/api/frontStatProdi', 'ApiController@perProdi')->name('front.perprodi');
Route::post('/api/frontTesti', 'ApiController@testi')->name('front.testi');
/* END ROUTE FRONT */

/* Route Pengaturan Akun */
Route::get('/setting', function () {
    if (Session::has('login')) {
        if (Session::get('level') == 'mahasiswa') {
            $data = Student::findOrFail(Session::get('nim'));
            return view('pages.wisudawan.setting', compact('data'));
        }
        return 'Error 403 : Forbidden access';
    }

    return redirect('login');
})->name('setting');

/* Route Dashboard */
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/api/counting', 'DashboardController@counting')->name('api.counting');
Route::post('/api/rank', 'DashboardController@rank')->name('api.rank');
Route::get('/api/chartGrad', 'DashboardController@chartGrad')->name('api.chartGrad');
Route::get('/api/chartIpk', 'DashboardController@chartIpk')->name('api.chartIpk');
Route::get('/api/chartProdi', 'DashboardController@chartProdi')->name('api.chartProdi');

/* Route Authentikasi */
Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login/admin', 'AuthController@admin_auth')->name('login.admin');
Route::post('/login/student', 'AuthController@student_auth')->name('login.student');
Route::get('/logout', 'AuthController@logout')->name('logout');

/* Route Prodi */
Route::resource('/prodi', 'DepartementController');
Route::get('/api/prodi', 'DepartementController@dataTables')->name('api.prodi');

/* Route Wisuda */
Route::resource('/wisuda', 'GraduationController');
Route::get('/api/graduation', 'GraduationController@dataTables')->name('api.graduation');

/* Route Wisudawan */
Route::resource('/wisudawan', 'StudentController');
Route::get('/api/wisudawan', 'StudentController@dataTables')->name('api.wisudawan');
Route::post('/wisudawan/import', 'StudentController@import')->name('wisudawan.import');
Route::get('/profile', 'StudentController@profile')->name('profile');
Route::post('/profile/{id}', 'StudentController@updateProfile')->name('profile.update');
Route::post('/unggahPhoto', 'StudentController@unggahPhoto')->name('unggah.photo');
//Route::get('/setting', 'StudentController@reset')->name('wisudawan.setting');
Route::post('/setting/{id}', 'StudentController@doReset')->name('wisudawan.doReset');
Route::get('/download', 'StudentController@download')->name('download');
Route::post('/export', 'StudentController@export')->name('export');

/* Route Administrator */
Route::resource('/admin', 'AdministratorController');
Route::get('/api/admin', 'AdministratorController@dataTables')->name('api.admin');
Route::get('/reset/{id}/akun', 'AdministratorController@reset')->name('admin.reset');
Route::put('/reset/{id}', 'AdministratorController@doReset')->name('admin.doReset');


/*Route Verifikasi */
Route::resource('/verifikasi', 'VerificationController');
Route::get('/api/verifikasi', 'VerificationController@dataTables')->name('api.verifications');
Route::get('/upload', 'VerificationController@upload')->name('upload');
Route::post('/unggahPembayaran', 'VerificationController@pembayaran')->name('pembayaran');
Route::post('/unggahLppm', 'VerificationController@lppm')->name('lppm');
Route::post('/unggahPerpus', 'VerificationController@perpus')->name('perpus');
Route::post('/verif/{id}', 'VerificationController@verif')->name('verif');

/*Route Testimoni */
Route::get('/testimoni', 'TestimonialController@index');
Route::delete('/testimoni/{id}', 'TestimonialController@destroy')->name('testi.destroy');
Route::post('/testimoni/store', 'TestimonialController@store')->name('testi.store');
Route::put('/testimoni/{id}', 'TestimonialController@update')->name('testi.update');
Route::get('/api/testimoni', 'TestimonialController@dataTables')->name('api.testimoni');

/*Route Peringkat */
Route::resource('/peringkat', 'RankController');
Route::post('/api/peringkat', 'RankController@dataTables')->name('api.peringkat');
