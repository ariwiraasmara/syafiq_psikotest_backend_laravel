<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use App\Http\Middleware\SecondBearerTokenCheck;
use App\Http\Middleware\CacheControlMiddleware;
use App\Http\Middleware\CheckTokenLogin;
use App\Http\Middleware\ContentSecurityPolicy;
use App\Http\Middleware\LogRequest;
use App\Http\Middleware\MatchingUserData;
use App\Http\Middleware\Pranker;
use App\Http\Middleware\UserRememberTokenCheck;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Libraries\myroute;
use App\Models\User;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/oauth/token', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

//? PUBLIC API ROUTE DENGAN LOGIN OTORISASI DAN MIDDLEWARE
Route::middleware([
    CacheControlMiddleware::class,
    'auth:api',
    'throttle:150,1', // 150 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    // 'throttle:pranker',
    Pranker::class,
    CheckTokenLogin::class,
    SecondBearerTokenCheck::class,
    MatchingUserData::class,
    UserRememberTokenCheck::class
])->group(function () {
    Route::get('/dashboard_admin', myroute::API('UserController', 'dashboard'))
        ->name('api_admin_dashboard');

    //? UserController
    Route::get('user-admin-all', myroute::API('UserController', 'all'))->name('api_useradmin_all');
    Route::get('user-admin/{sort}/{by}/{search}', myroute::API('UserController', 'allWithSearch'))->name('api_useradmin_allwithsearch');
    Route::get('user-admin/{id}', myroute::API('UserController', 'get'))->name('api_useradmin_get');
    Route::get('user-admin/{type}/{id}', myroute::API('UserController', 'detail'))->name('api_useradmin_detil');
    Route::post('user-admin', myroute::API('UserController', 'store'))->name('api_useradmin_store');
    Route::put('user-admin-account', myroute::API('UserController', 'updateAccount'))->name('api_useradmin_updateaccount');
    Route::put('user-admin-password', myroute::API('UserController', 'updatePassword'))->name('api_useradmin_updatepassword');
    Route::put('user-remembertoken', myroute::API('UserController', 'updateRemembertoken'))->name('api_user_updateremembertoken');
    Route::put('user-admin-pat', myroute::API('UserController', 'updatePAT'))->name('api_user_updatepat');
    Route::put('user-admin-profil', myroute::API('UserController', 'updateProfil'))->name('api_user_updateprofil');
    Route::put('user-admin-foto', myroute::API('UserController', 'updateFoto'))->name('api_user_updatefoto');
    Route::delete('user-admin/{type}/{id}', myroute::API('UserController', 'delete'))->name('api_user_delete');

    //? As0001VariabelsettingController
    Route::get('/variabel-setting/{sort}/{by}/{search}', myroute::API('As0001VariabelsettingController', 'all'))
        ->name('api_admin_variabel_setting_all');

    Route::post('/variabel-setting', myroute::API('As0001VariabelsettingController', 'store'))
        ->name('api_admin_variabel_setting_store');

    Route::put('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'update'))
        ->name('api_admin_variabel_setting_update');

    Route::delete('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'delete'))
        ->name('api_admin_variabel_setting_delete');

    //? As1001PesertaProfilController
    Route::get('/peserta/{sort}/{by}/{search}', myroute::API('As1001PesertaProfilController', 'all'))
        ->name('api_admin_peserta_all');

    Route::get('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'get'))
        ->name('api_admin_peserta_get');

    Route::delete('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'delete'))
        ->name('api_admin_peserta_delete');

    //? As1002PesertaHasilnilaiTesKecermatanController
    Route::get('/peserta/hasil/psikotest/kecermatan/semua/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'all'))
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_all');

    Route::get('/peserta/hasil/psikotest/kecermatan/{id}/{tgl_1}/{tgl_2}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'search'))
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_search');

    Route::delete('/peserta/hasil/psikotest/kecermatan/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'delete'))
        ->name('api_admin_peserta_hasil_psikotest_kecermatan_delete');

    //? As2001KecermatanKolompertanyaanController
    Route::get('/kecermatan-kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'all'))
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_all');

    Route::get('/kecermatan/pertanyaan/{val}', myroute::API('As2001KecermatanKolompertanyaanController', 'get'))
        ->name('api_admin_psikotest_kecermatan_pertanyaan_get');

    Route::post('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'store'))
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_store');

    Route::put('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'update'))
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_update');

    Route::delete('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'delete'))
        ->name('api_admin_psikotest_kecermatan_kolompertanyaan_delete');

    //? As2002KecermatanSoaljawabanController
    Route::get('/kecermatan/soaljawaban/all/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allRaw'))
        ->name('api_admin_psikotest_kecermatan_soaljawaban_allraw');

    Route::post('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'store'))
        ->name('api_admin_psikotest_kecermatan_soaljawaban_store');

    Route::put('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'update'))
        ->name('api_admin_psikotest_kecermatan_soaljawaban_update');

    Route::delete('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'delete'))
        ->name('api_admin_psikotest_kecermatan_soaljawaban_delete');

    //? As5001BlogController
    Route::get('/admin-blog/{sort}/{by}/{search}', myroute::API('As5001BlogController', 'all'))
        ->name('api_blog_all');

    Route::get('/admin-blog/{id}', myroute::API('As5001BlogController', 'get'))
        ->name('api_blog_get');

    Route::get('/blog', myroute::API('As5001BlogController', 'publicAll'))
        ->name('api_blog_publicAll');

    Route::get('/blog/{recents}', myroute::API('As5001BlogController', 'publicRecent'))
        ->name('api_blog_publicRecent');

    Route::get('/blog/{field}/{search}', myroute::API('As5001BlogController', 'publicSearch'))
        ->name('api_blog_publicSearch');

    Route::get('/blog-detil/{title}', myroute::API('As5001BlogController', 'publicDetail'))
        ->name('api_blog_publicDetail');

    Route::get('/admin-blog', myroute::API('As5001BlogController', 'store'))
        ->name('api_blog_store');

    Route::get('/admin-blog/{id}', myroute::API('As5001BlogController', 'update'))
        ->name('api_blog_update');

    Route::get('/admin-blog/{type}/{id}', myroute::API('As5001BlogController', 'delete'))
        ->name('api_blog_delete');

    //? MonitorUserLogActivitiesController
    Route::get('/monitor/user-log-activities/{sort}/{by}/{search}', myroute::API('MonitorUserLogActivitiesController', 'allUser'))
        ->name('api_monitor_userlogactivities_allUser');

    Route::get('/monitor/user-log-activities/{type}/{id}/{sort}/{by}/{search}', myroute::API('MonitorUserLogActivitiesController', 'getUser'))
        ->name('api_monitor_userlogactivities_getUser');
        
    Route::get('/monitor/user-log-activities-truncate-all', myroute::API('MonitorUserLogActivitiesController', 'truncate'))
        ->name('api_monitor_userlogactivities_truncate');

    Route::get('/monitor/user-log-activities/{id}', myroute::API('MonitorUserLogActivitiesController', 'deleteOneUserAdminActivities'))
        ->name('api_monitor_userlogactivities_deleteOneUserAdminActivities');

    Route::get('/monitor/user-log-activities-backup-all', myroute::API('MonitorUserLogActivitiesController', 'backupAll'))
        ->name('api_monitor_userlogactivities_backupAll');

    Route::get('/monitor/user-log-activities-backup/{id}', myroute::API('MonitorUserLogActivitiesController', 'backupUser'))
        ->name('api_monitor_userlogactivities_backupUser');
});

Route::middleware([
    'throttle:10,1', // 5 permintaan per menit, mencegah serangan DDoS dalam pengiriman data yang berlebihan
    CheckTokenLogin::class,
    CacheControlMiddleware::class,
    LogRequest::class
])->group(function () {
    Route::middleware(['throttle:login'])->post('/login', myroute::API('UserController', 'login'))
        ->name('login');

    Route::get('/logout', myroute::API('UserController', 'logout'))
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
            ->name('api_variabel_setting_get');

        Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allCooked'))
            ->name('api_kecermatan_soaljawaban_get');

        Route::post('/peserta/setup', myroute::API('As1001PesertaProfilController', 'setUpPesertaTes'))
            ->name('api_peserta_setup');

        Route::post('/peserta', myroute::API('As1001PesertaProfilController', 'store'))
            ->name('api_peserta_store');

        Route::put('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'update'))
            ->name('api_peserta_update');

        Route::get('/peserta-hasil-tes/{id}/{tgl}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'get'))
            ->name('api_peserta_hasil_tes_psikotes_get');

        Route::post('/peserta-hasil-tes/{id}/{nid}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'store'))
            ->name('api_peserta_hasil_tes_psikotes_store');
});

Route::get('/signed-url/{name}', myroute::api('GenerateSignedURLController', 'signedUrl'))->name('api_signedUrl');
Route::get('/signed-temporary-url/{name}/{minute}', myroute::api('GenerateSignedURLController', 'signedTemporaryURL'))->name('api_signedTemporaryURL');

Route::post('/csp-report', myroute::api('Security\CSPReportController', 'store'))
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

//? PUBLIC API ROUTE TANPA MIDDLEWARE
Route::get('/csrf_token', myroute::API('AnyController', 'csrf_token'))
    ->name('csrf_token');

Route::get('/generate-token-first', myroute::API('AnyController', 'generate_token_first'))
    ->name('generate_token_first');

Route::get('/generate-api-key', myroute::API('AnyController', 'generate_api_key'))
    ->name('generate_api_key');

Route::post('/testAdminToken', myroute::API('AnyController', 'testAdminToken'))
    ->middleware([SecondBearerTokenCheck::class, UserRememberTokenCheck::class]);

Route::get('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
    ->middleware([SecondBearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class]);

Route::post('/testAPIwithAnyMiddleware', myroute::API('AnyController', 'testAPIwithAnyMiddleware'))
    ->middleware([SecondBearerTokenCheck::class, CheckTokenLogin::class, MatchingUserData::class, CacheControlMiddleware::class, UserRememberTokenCheck::class, Pranker::class, LogRequest::class]);

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