<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use App\Http\Middleware\CacheControlMiddleware;
use App\Http\Middleware\CheckTokenLogin;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\MatchingUserData;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\myroute;
use Illuminate\Support\Facades\Log;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/token', function (Request $request) {
    // return $request;
    if($request->key) {
        $session = session('key', 'default');
        // $token = $request->session()->token();
        // $token = csrf_token();
        // $token = fun::encrypt(fun::enval(fun::random('combwisp', 20)));
        Log::info('CSRF Token: '.$token);  // Log token ke file log
        $response = new Response([
            'message' => 'CSRF Token Generated!',
            'token' => $token,
            'session' => $session,
        ]);
        return $response;
    }
    return new Response([
        'error'     => 1,
        'message'   => 'Key is null!'
    ]);
})->middleware([CacheControlMiddleware::class]);

Route::post('/login', myroute::API('UserController', 'login'));
    // ->middleware(VerifyCsrfToken::class);
    // ->middleware([CheckTokenLogin::class, CacheControlMiddleware::class]);

Route::get('/logout', myroute::API('UserController', 'logout'));

// if(fun::getRawCookie('islogin')) {
//     Route::middleware([EnsureEmailIsVerified::class, MatchingUserData::class])->group(function () {
//         Route::middleware([MatchingUserData::class])->group(function () {
                Route::get('/dashboard_admin', myroute::API('UserController', 'dashboard'));

                // As0001VariabelsettingController
                Route::get('/variabel-setting', myroute::API('As0001VariabelsettingController', 'all'));
                Route::get('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'get'));
                Route::post('/variabel-setting', myroute::API('As0001VariabelsettingController', 'store'));
                Route::put('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'update'));
                Route::delete('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'delete'));

                //? As1001PesertaProfilController
                Route::get('/peserta', myroute::API('As1001PesertaProfilController', 'all'));
                Route::get('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'get'));
                Route::delete('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'delete'));

                //? As1002PesertaHasilnilaiTesKecermatanController
                Route::get('/peserta/hasil-tes/semua/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'all'));
                Route::delete('/peserta/hasil-tes/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'delete'));

                //? As2001KecermatanKolompertanyaanController
                Route::get('/kecermatan-kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'all'));
                Route::get('/kecermatan/pertanyaan/{val}', myroute::API('As2001KecermatanKolompertanyaanController', 'get'));
                Route::post('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'store'));
                Route::put('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'update'));
                Route::delete('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'delete'));

                //? As2002KecermatanSoaljawabanController
                Route::get('/kecermatan/soaljawaban/all/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allRaw'));
                Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'allCooked'));
                Route::post('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'store'));
                Route::put('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'update'));
                Route::delete('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'delete'));
    //     });
    // });
// }

Route::get('/generate-token-first', myroute::API('As1001PesertaProfilController', 'generate_token_first'));
// if(fun::getRawCookie('__token__')) {
    // if(fun::getRawCookie('__unique__')) {
        Route::post('/peserta/setup', myroute::API('As1001PesertaProfilController', 'setUpPesertaTes'));
        Route::post('/peserta', myroute::API('As1001PesertaProfilController', 'store'));
        Route::put('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'update'));

        Route::get('/peserta/hasil-tes/{id}/{tgl}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'get'));
        Route::post('/peserta/hasil-tes/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'store'));
        // Route::put('/peserta/hasil-tes/{id}', myroute::API('As1002PesertaHasilnilaiTesKecermatanController', 'update'));
    // }
// }

Route::get('/json/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'json'));

Route::get('/hello', function(Request $request) {
    // ['id2001' => 1, 'soal_jawaban' => '{"0":2, "1":1, "2":9, "3":5, "4":7}'],
    // $k11 = collect(["soal" => ['0'=>2, '1'=>1, '2'=>9, '3'=>5], "jawaban" => 7]);
    $k11 = json_encode(['soal' => [7, 2, 5, 1], 'jawaban' => 9]);
    return 'hello '.$k11;
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

