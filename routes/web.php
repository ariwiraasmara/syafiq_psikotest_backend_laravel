<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Libraries\myroute;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;

Route::middleware(
    'throttle:250,1', // 250 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    Route::get('/', function() {
        return Inertia::render('Home', [
            'title'     => 'Psikotest Online App',
            'pathURL'   => url()->current(),
            'robots'    => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'   => true
        ]);
    });

    Route::get('peserta', myroute::view('Peserta\Page', 'index'));
    if( fun::getRawCookie('ispeserta') ) {
        Route::get('peserta/psikotest/kecermatan', myroute::view('Peserta\Psikotest\Kecermatan\Page', 'index'));
    }
    Route::get('peserta/psikotest/kecermatan/hasil/{no_identitas}/{tgl_tes}', myroute::view('Peserta\Psikotest\Kecermatan\Hasil\Page', 'index'));
});

Route::middleware(
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    Route::get('admin', myroute::view('Admin\Page', 'index'));
    Route::post('admin/login', myroute::view('Admin\Page', 'login'));
    Route::get('logout', myroute::view('Logout', 'index'));
});

Route::middleware(
    'auth',
    'throttle:50,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    if( fun::getRawCookie('islogin') &&
        fun::getRawCookie('isadmin') &&
        fun::getRawCookie('isauth')
    ) {
        Route::get('admin/dashboard', myroute::view('Admin\Dashboard\Page', 'index'));

        Route::get('admin/peserta/{page}', myroute::view('Admin\Peserta\Page', 'index'));
        Route::get('admin/peserta-edit', myroute::view('Admin\Peserta\Edit\Page', 'index'));
        Route::get('admin/peserta-detil/{id}', myroute::view('Admin\Peserta\Detil\Page', 'index'));

        Route::get('admin/psikotest', myroute::view('Admin\Psikotest\Page', 'index'));
        Route::get('admin/psikotest/kecermatan', myroute::view('Admin\Psikotest\Kecermatan\Page', 'index'));
        Route::get('admin/psikotest/kecermatan-baru', myroute::view('Admin\Psikotest\Kecermatan\Baru\Page', 'index'));
        Route::get('admin/psikotest/kecermatan-edit', myroute::view('Admin\Psikotest\Kecermatan\Edit\Page', 'index'));
        Route::get('admin/psikotest/kecermatan/detil/{page}', myroute::view('Admin\Psikotest\Kecermatan\Detil\Page', 'index'));
        Route::get('admin/psikotest/kecermatan/detil-baru', myroute::view('Admin\Psikotest\Kecermatan\Detil\Baru\Page', 'index'));
        Route::get('admin/psikotest/kecermatan/detil-edit', myroute::view('Admin\Psikotest\Kecermatan\Detil\Edit\Page', 'index'));

        Route::get('admin/variabel/{page}', myroute::view('Admin\Variabel\Page', 'index'));
        Route::get('admin/variabel-baru', myroute::view('Admin\Variabel\Baru\Page', 'index'));
        Route::get('admin/variabel-edit', myroute::view('Admin\Variabel\Edit\Page', 'index'));
    }
});

Route::get('hello', function(){
    return url()->current();
});

Route::get('hello-auth', function(){
    if (Auth::check()) {
        // The user is logged in...
        return 'hello... AUTH';
    }
    return 'hello... UGH!';
});

require __DIR__.'/auth.php';
