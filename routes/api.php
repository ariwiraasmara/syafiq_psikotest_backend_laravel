<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use App\Http\Middleware\BearerTokenCheck;
use App\Http\Middleware\CacheControlMiddleware;
use App\Http\Middleware\CheckTokenLogin;
use App\Http\Middleware\ContentSecurityPolicy;
use App\Http\Middleware\IndexedDB;
use App\Http\Middleware\LogRequest;
use App\Http\Middleware\MatchingUserData;
use App\Http\Middleware\Pranker;
use App\Http\Middleware\UserRememberTokenCheck;
use App\Http\Middleware\VerifyFastApiKey;
use App\Http\Middleware\XRobotTags;
use App\Http\Middleware\XRobotUntags;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Libraries\myroute;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//? PUBLIC API ROUTE DENGAN LOGIN OTORISASI DAN MIDDLEWARE
Route::middleware([
    'throttle:100,1', // 50 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    BearerTokenCheck::class,
    // VerifyFastApiKey::class,
    CheckTokenLogin::class,
    MatchingUserData::class,
    CacheControlMiddleware::class,
    UserRememberTokenCheck::class,
    Pranker::class,
    LogRequest::class
])->group(function () {
    Route::get('/dashboard_admin', myroute::API('UserController', 'dashboard'))
            ->middleware([XRobotTags::class]);

    //? As0001VariabelsettingController
    Route::get('/variabel-setting/{sort}/{by}/{search}', myroute::API('As0001VariabelsettingController', 'all'))
            ->middleware([XRobotTags::class]);

    Route::post('/variabel-setting', myroute::API('As0001VariabelsettingController', 'store'))
            ->middleware([XRobotUntags::class]);

    Route::put('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'update'))
            ->middleware([XRobotUntags::class]);

    Route::delete('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'delete'))
            ->middleware([XRobotUntags::class]);

    //? As1001PesertaProfilController
    Route::get('/peserta/{sort}/{by}/{search}', myroute::API('As1001PesertaProfilController', 'all'))
            ->middleware([XRobotTags::class]);

    Route::get('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'get'))
            ->middleware([XRobotTags::class]);

    Route::delete('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'delete'))
            ->middleware([XRobotUntags::class]);

    //? As1002PesertaHasilnilaiTesKecermatanController
    Route::get('/peserta/hasil/psikotest/kecermatan/semua/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'all'))
            ->middleware([XRobotTags::class]);

    Route::get('/peserta/hasil/psikotest/kecermatan/{id}/{tgl_1}/{tgl_2}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'search'))
            ->middleware([XRobotTags::class]);

    Route::delete('/peserta/hasil/psikotest/kecermatan/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'delete'))
            ->middleware([XRobotUntags::class]);

    //? As2001KecermatanKolompertanyaanController
    Route::get('/kecermatan-kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'all'))
            ->middleware([XRobotTags::class]);

    Route::get('/kecermatan/pertanyaan/{val}', myroute::API('As2001KecermatanKolompertanyaanController', 'get'))
            ->middleware([XRobotTags::class]);

    Route::post('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'store'))
            ->middleware([XRobotUntags::class]);

    Route::put('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'update'))
            ->middleware([XRobotUntags::class]);

    Route::delete('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'delete'))
            ->middleware([XRobotUntags::class]);

    //? As2002KecermatanSoaljawabanController
    Route::get('/kecermatan/soaljawaban/all/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allRaw'))
            ->middleware([XRobotUntags::class]);

    Route::post('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'store'))
            ->middleware([XRobotUntags::class]);

    Route::put('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'update'))
            ->middleware([XRobotUntags::class]);

    Route::delete('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'delete'))
            ->middleware([XRobotUntags::class]);
});

Route::middleware([
    'throttle:5,1', // 5 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // VerifyFastApiKey::class,
    CheckTokenLogin::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
    Route::post('/login', myroute::API('UserController', 'login'))
            ->middleware([XRobotUntags::class]);

    Route::get('/logout', myroute::API('UserController', 'logout'))
            ->middleware([XRobotUntags::class]);
});

Route::middleware([
    CheckTokenLogin::class,
    Pranker::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
    Route::get('/psikotest/kecermatan/pertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'allForTes'));
    Route::get('/psikotest/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allForTes'));
});

Route::middleware([
    // 'throttle:100,1', // 100 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // VerifyFastApiKey::class,
    CheckTokenLogin::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
    Route::get('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'get'))
            ->middleware([XRobotUntags::class]);

    Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allCooked'))
            ->middleware([XRobotUntags::class]);

    Route::post('/peserta/setup', myroute::API('As1001PesertaProfilController', 'setUpPesertaTes'))
            ->middleware([XRobotUntags::class]);

    Route::post('/peserta', myroute::API('As1001PesertaProfilController', 'store'))
            ->middleware([XRobotUntags::class]);

    Route::put('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'update'))
            ->middleware([XRobotUntags::class]);

    Route::post('/peserta-hasil-tes/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'store'))
            ->middleware([XRobotUntags::class]);

    Route::get('/peserta-hasil-tes/{id}/{tgl}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'get'))
            ->middleware([XRobotTags::class]);
});

//? PUBLIC API ROUTE TANPA MIDDLEWARE
Route::get('/csrf_token', myroute::API('AnyController', 'csrf_token'))
            ->middleware([XRobotUntags::class]);

Route::get('/generate-token-first', myroute::API('AnyController', 'generate_token_first'))
            ->middleware([XRobotUntags::class]);

Route::get('/generate-api-key', myroute::API('AnyController', 'generate_api_key'))
            ->middleware([XRobotUntags::class]);

Route::post('/testAdminToken', myroute::API('AnyController', 'testAdminToken'))
    ->middleware([BearerTokenCheck::class, UserRememberTokenCheck::class]);

Route::get('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
    ->middleware([BearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class]);

Route::post('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
    ->middleware([BearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class, Pranker::class, LogRequest::class]);

//? PUBLIC API ROUTE PERCOBAAN
Route::get('/hello', function(Request $request) {
    // ['id2001' => 1, 'soal_jawaban' => '{"0":2, "1":1, "2":9, "3":5, "4":7}'],
    // $k11 = collect(["soal" => ['0'=>2, '1'=>1, '2'=>9, '3'=>5], "jawaban" => 7]);
    $k11 = json_encode(['soal' => [7, 2, 5, 1], 'jawaban' => 9]);
    return 'hello '.$k11;
})->middleware([VerifyFastApiKey::class]);

Route::post('/hello', function(){
    return 'hello';
});

Route::put('/hello', function(){
    return 'hello';
});

Route::delete('/hello', function(){
    return 'hello';
});

