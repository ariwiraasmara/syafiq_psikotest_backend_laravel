<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use Illuminate\Support\Facades\Route;
use App\Libraries\myroute;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CustomThrottleRequests;

Route::get('/', myroute::view('Home', 'bladeView'));
Route::get('peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}', myroute::view('Peserta\Psikotest\Kecermatan\Hasil\Page', 'bladeView'));
Route::get('generate-sitemap', myroute::view('MySitemapController', 'generate'));

Route::middleware(
    'throttle:250,1', // 200 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    Route::get('peserta', myroute::view('Peserta\Page', 'bladeView'));
    if( fun::getRawCookie('ispeserta') ) {
        Route::get('peserta/psikotest/kecermatan/{sesi}', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'bladeView'));
        Route::get('psikotest/kecermatan/pertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'allForTes'));
        Route::get('psikotest/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allForTes'));
    }
});

Route::middleware(
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // 'customThrottle:50,1'
)->group(function () {
    Route::get('admin', myroute::view('Admin\Page', 'bladeView'));
    Route::post('admin/login', myroute::view('Admin\Page', 'login'));
    Route::get('logout', myroute::view('Logout', 'bladeView'));
});

Route::middleware(
    'auth',
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    if( fun::getRawCookie('XSRF-TOKEN') &&
        fun::getRawCookie('__sysauth__') &&
        fun::getRawCookie('__token__') &&
        fun::getRawCookie('islogin') &&
        fun::getRawCookie('isadmin') &&
        fun::getRawCookie('isauth')
    ) {
        Route::get('admin/dashboard', myroute::view('Admin\Dashboard\Page', 'bladeView'))->name('dashboard_admin');

        Route::get('admin/peserta/{sort}/{by}/{search}', myroute::view('Admin\Peserta\Page', 'bladeView'));
        Route::get('admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'bladeView'));
        Route::put('admin/peserta-edit/{id}', myroute::view('Admin\Peserta\Edit\Page', 'update'));
        Route::get('admin/peserta-detil/{tgl1}/{tgl2}/{id}', myroute::view('Admin\Peserta\Detil\Page', 'bladeView'));

        Route::get('admin/psikotest', myroute::view('Admin\Psikotest\Page', 'bladeView'));
        Route::get('admin/psikotest/kecermatan', myroute::view('Admin\Psikotest\Kecermatan\Page', 'bladeView'));
        Route::get('admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'bladeView'));
        Route::post('admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'store'));
        Route::get('admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'bladeView'));
        Route::put('admin/psikotest/kecermatan-edit/{id}', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'update'));
        Route::delete('admin/psikotest/kecermatan-delete/{id}', myroute::view('Admin\Psikotest\Kecermatan\Page', 'delete'));
        
        Route::get('admin/psikotest/kecermatan/detil/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'bladeView'));
        Route::get('admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'bladeView'));
        Route::post('admin/psikotest/kecermatan/detil-baru/{id}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'store'));
        Route::get('admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'bladeView'));
        Route::put('admin/psikotest/kecermatan/detil-edit/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'update'));
        Route::delete('admin/psikotest/kecermatan/detil-delete/{id1}/{id2}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'delete'));

        Route::get('admin/variabel-setting/{sort}/{by}/{search}', myroute::view('Admin\Variabel\Page', 'bladeView'));
        Route::get('admin/variabel-baru',  myroute::view('Admin\Variabel\Baru\Page', 'bladeView'));
        Route::post('admin/variabel-baru', myroute::view('Admin\Variabel\Baru\Page', 'store'));
    
        Route::get('admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'bladeView'));
        Route::put('admin/variabel-edit/{id}', myroute::view('Admin\Variabel\Edit\Page', 'update'));
        Route::delete('admin/variabel-delete/{id}', myroute::view('Admin\Variabel\Page', 'delete'));
    }
});

Route::get('hello', function(){
    return url()->current();
});

Route::get('hello-auth', function(){
    if (Auth::check()) {
        // The user is logged in...
        // return var_dump(Auth());
        return 'hello... AUTH';
    }
    return 'hello... UGH!';
});

Route::get('/test-cookie', function () {
    return response('Test Cookie')->cookie(
        'test_cookie', 'test_value', 60, '/', null, false, true, false, 'Lax'
    );
});

// require __DIR__.'/auth.php';