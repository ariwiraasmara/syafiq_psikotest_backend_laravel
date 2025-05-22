<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use App\Libraries\myroute;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CustomThrottleRequests;

Route::get('/', myroute::view('Home', 'reactView'))->name('home');
Route::get('/peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}', myroute::view('Peserta\Psikotest\Kecermatan\Hasil\Page', 'bladeView'))->name('peserta_psikotest_kecermatan_hasil');
Route::get('/generate-sitemap', myroute::view('MySitemapController', 'generate'))->name('generate_sitemap');

Route::middleware(
    'throttle:250,1', // 200 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    Route::get('/peserta', myroute::view('Peserta\Page', 'bladeView'))->name('peserta');
    
    Route::post('/peserta/setup', myroute::view('Peserta\Page', 'setUpPesertaTes'))
                ->name('peserta_setup');
    if( fun::getRawCookie('ispeserta') ) {
        Route::get('/peserta/psikotest/kecermatan/{sesi}', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'bladeView'))->name('peserta_psikotest_kecermatan');
        Route::post('/peserta-psikotest-kecermatan/{id}', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'store'))->name('peserta_psikotest_kecermatan_store');
        Route::get('/psikotest/kecermatan/pertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'allForTes'))->name('psikotest_kecermatan_pertanyaan');
        Route::get('/psikotest/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allForTes'))->name('psikotest_kecermatan_soaljawaban');
    }
});

Route::middleware(
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // 'customThrottle:50,1'
)->group(function () {
    Route::get('admin', myroute::view('Admin\Page', 'view'))->name('admin');
    Route::post('admin/login', myroute::view('Admin\Page', 'login'))->name('admin_login');
    Route::get('logout', myroute::view('Logout', 'bladeView'))->name('logout');
});

Route::middleware(
    'auth',
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    if( fun::getRawCookie('islogin') &&
        fun::getRawCookie('isadmin') &&
        fun::getRawCookie('isauth')
    ) {
        Route::get('/admin/dashboard', myroute::view('Admin\Dashboard\Page', 'bladeView'))->name('admin_dashboard');

        Route::get('/admin/peserta/{sort}/{by}/{search}', myroute::view('Admin\Peserta\Page', 'bladeView'))->name('admin_peserta');
        Route::get('/admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'bladeView'))->name('admin_peserta_edit');
        Route::put('/admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'update'))->name('admin_peserta_update');
        Route::get('/admin/peserta-detil/{tgl1}/{tgl2}/{id}', myroute::view('Admin\Peserta\Detil\Page', 'bladeView'))->name('admin_peserta_detil');

        Route::get('/admin/psikotest', myroute::view('Admin\Psikotest\Page', 'bladeView'))->name('admin_psikotest');
        Route::get('/admin/psikotest/kecermatan', myroute::view('Admin\Psikotest\Kecermatan\Page', 'bladeView'))->name('admin_psikotest_kecermatan');
        Route::get('/admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'bladeView'))->name('admin_psikotest_kecermatan_baru');
        Route::post('/admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'store'))->name('admin_psikotest_kecermatan_store');
        Route::get('/admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'bladeView'))->name('admin_psikotest_kecermatan_edit');
        Route::put('/admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'update'))->name('admin_psikotest_kecermatan_update');
        Route::delete('/admin/psikotest/kecermatan-delete/{id}', myroute::view('Admin\Psikotest\Kecermatan\Page', 'delete'))->name('admin_psikotest_kecermatan_delete');
        
        Route::get('/admin/psikotest/kecermatan/detil/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil');
        Route::get('/admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil_baru');
        Route::post('/admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'store'))->name('admin_psikotest_kecermatan_detil_store');
        Route::get('/admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'bladeView'))->name('admin_psikotest_kecermatan_detil_edit');
        Route::put('/admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'update'))->name('admin_psikotest_kecermatan_detil_update');
        Route::delete('/admin/psikotest/kecermatan/detil-delete/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'delete'))->name('admin_psikotest_kecermatan_detil_delete');

        Route::get('/admin/variabel-setting/{sort}/{by}/{search}', myroute::view('Admin\Variabel\Page', 'bladeView'))->name('admin_variabel_setting');
        Route::get('/admin/variabel-baru',  myroute::view('Admin\Variabel\Baru\Page', 'bladeView'))->name('admin_variabel_baru');
        Route::post('/admin/variabel-baru', myroute::view('Admin\Variabel\Baru\Page', 'store'))->name('admin_variabel_store');
        Route::get('/admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'bladeView'))->name('admin_variabel_edit');
        Route::put('/admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'update'))->name('admin_variabel_update');
        Route::delete('/admin/variabel-delete/{id}', myroute::view('Admin\Variabel\Page', 'delete'))->name('admin_variabel_delete');
    }
});

Route::get('hello', function(){
    // return url()->current();
    return csrf_token();
});

Route::get('hello-auth', function(){
    if (Auth::check()) {
        // The user is logged in...
        // return var_dump(Auth());
        return 'hello... AUTH';
    }
    return 'hello... UGH!';
});

Route::get('/test-cookie', function (Request $request) {
    Cookie::queue('isloginnnnnnnnn', true, (60*24*60*60), '/', 'https://psikotesasyik.com', true, true, false, 'none');
    $request->session()->put('session', 'I am SESSION!');
    return response('Test Cookie')->cookie(
        'test_cookie', 'test_value', 60, '/', null, false, true, false, 'none'
    );
});

Route::get('/test-session', function (Request $request) {
    return $request->session()->get('session');
});

// require __DIR__.'/auth.php';