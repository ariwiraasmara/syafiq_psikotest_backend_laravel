<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use App\Http\Middleware\BearerTokenCheck;
use App\Http\Middleware\CacheControlMiddleware;
use App\Http\Middleware\CheckTokenLogin;
use App\Http\Middleware\ContentSecurityPolicy;
use App\Http\Middleware\LogRequest;
use App\Http\Middleware\MatchingUserData;
use App\Http\Middleware\Pranker;
use App\Http\Middleware\UserRememberTokenCheck;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\XRobotTags;
use App\Http\Middleware\XRobotUntags;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Libraries\myroute;
use App\Models\User;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//? PUBLIC API ROUTE DENGAN LOGIN OTORISASI DAN MIDDLEWARE
Route::middleware([
    // 'auth:api',
    'throttle:150,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    BearerTokenCheck::class,
    CheckTokenLogin::class,
    MatchingUserData::class,
    CacheControlMiddleware::class,
    UserRememberTokenCheck::class,
    Pranker::class,
    LogRequest::class
])->group(function () {
    Route::get('/dashboard_admin', myroute::API('UserController', 'dashboard'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_dashboard');

    //? As0001VariabelsettingController
    Route::get('/variabel-setting/{sort}/{by}/{search}', myroute::API('As0001VariabelsettingController', 'all'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_variabel_setting_all');

    Route::post('/variabel-setting', myroute::API('As0001VariabelsettingController', 'store'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_variabel_setting_store');

    Route::put('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'update'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_variabel_setting_update');

    Route::delete('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'delete'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_variabel_setting_delete');

    //? As1001PesertaProfilController
    Route::get('/peserta/{sort}/{by}/{search}', myroute::API('As1001PesertaProfilController', 'all'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_peserta_all');

    Route::get('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'get'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_peserta_get');

    Route::delete('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'delete'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_peserta_delete');

    //? As1002PesertaHasilnilaiTesKecermatanController
    Route::get('/peserta/hasil/psikotest/kecermatan/semua/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'all'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_all');

    Route::get('/peserta/hasil/psikotest/kecermatan/{id}/{tgl_1}/{tgl_2}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'search'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_search');

    Route::delete('/peserta/hasil/psikotest/kecermatan/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'delete'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_delete');

    //? As2001KecermatanKolompertanyaanController
    Route::get('/kecermatan-kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'all'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_all');

    Route::get('/kecermatan/pertanyaan/{val}', myroute::API('As2001KecermatanKolompertanyaanController', 'get'))
        ->middleware([XRobotTags::class])
        ->name('api_admin_psikotest_kecermatan_pertanyaan_get');

    Route::post('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'store'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_store');

    Route::put('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'update'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_update');

    Route::delete('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'delete'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_delete');

    //? As2002KecermatanSoaljawabanController
    Route::get('/kecermatan/soaljawaban/all/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allRaw'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_soaljawaban_allraw');

    Route::post('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'store'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_soaljawaban_store');

    Route::put('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'update'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_soaljawaban_update');

    Route::delete('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'delete'))
        ->middleware([XRobotUntags::class])
        ->name('api_admin_psikotest_kecermatan_soaljawaban_delete');
});

Route::middleware([
    'throttle:10,1', // 5 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    CheckTokenLogin::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
        Route::post('/login', myroute::API('UserController', 'login'))
        ->middleware([XRobotUntags::class])
        ->name('login');

        Route::get('/logout', myroute::API('UserController', 'logout'))
        ->middleware([XRobotUntags::class])
        ->name('logout');
});

/*
Route::middleware([
    CheckTokenLogin::class,
    Pranker::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
    Route::get('/psikotest/kecermatan/pertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'allForTes'))
        ->name('api_psikotest_kecermatan_pertanyaan_allfortes');
    Route::get('/psikotest/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allForTes'))
        ->name('api_psikotest_kecermatan_soaljawaban_allfortes');
});
*/

Route::middleware([
    // 'throttle:100,1', // 100 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    CheckTokenLogin::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
        Route::get('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'get'))
                ->middleware([XRobotUntags::class])
                ->name('api_variabel_setting_get');

        Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allCooked'))
                ->middleware([XRobotUntags::class])
                ->name('api_kecermatan_soaljawaban_get');

        Route::post('/peserta/setup', myroute::API('As1001PesertaProfilController', 'setUpPesertaTes'))
                ->middleware([XRobotUntags::class])
                ->name('api_peserta_setup');

        Route::post('/peserta', myroute::API('As1001PesertaProfilController', 'store'))
                ->middleware([XRobotUntags::class])
                ->name('api_peserta_store');

        Route::put('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'update'))
                ->middleware([XRobotUntags::class])
                ->name('api_peserta_update');

        Route::get('/peserta-hasil-tes/{id}/{tgl}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'get'))
                ->middleware([XRobotTags::class])
                ->name('api_peserta_hasil_tes_psikotes_get');

        Route::post('/peserta-hasil-tes/{id}/{nid}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'store'))
                ->middleware([XRobotUntags::class])
                ->name('api_peserta_hasil_tes_psikotes_store');
});

//? PUBLIC API ROUTE TANPA MIDDLEWARE
Route::get('/csrf_token', myroute::API('AnyController', 'csrf_token'))
        ->middleware([XRobotUntags::class])
        ->name('csrf_token');

Route::get('/generate-token-first', myroute::API('AnyController', 'generate_token_first'))
        ->middleware([XRobotUntags::class])
        ->name('generate_token_first');

Route::get('/generate-api-key', myroute::API('AnyController', 'generate_api_key'))
        ->middleware([XRobotUntags::class])
        ->name('generate_api_key');

Route::post('/testAdminToken', myroute::API('AnyController', 'testAdminToken'))
        ->middleware([BearerTokenCheck::class, UserRememberTokenCheck::class]);

Route::get('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
        ->middleware([BearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class]);

Route::post('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
        ->middleware([BearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class, Pranker::class, LogRequest::class]);

//? PUBLIC API ROUTE PERCOBAAN
Route::get('hello-auth', function(){
    if (Auth::check()) {
        // The user is logged in...
        // return var_dump(Auth());
        return 'hello... AUTH';
    }
    return 'hello... UGH!';
});

Route::get('/hello', function(Request $request) {
        $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
//     return 'hello';
        return $user['remember_token'];
});

Route::post('/hello', function(){
    return 'hello';
});

Route::put('/hello', function(){
    return 'hello';
});

Route::delete('/hello', function(){
    return 'hello';
});