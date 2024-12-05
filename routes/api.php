<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)

use App\Http\Middleware\CheckTokenLogin;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\MatchingUserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Libraries\myfunction as fun;
use App\Libraries\myroute;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', myroute::API('UserController', 'login'))
    ->middleware(CheckTokenLogin::class);

if(fun::getRawCookie('islogin')) {
    Route::middleware([EnsureEmailIsVerified::class, MatchingUserData::class])->group(function () {
        Route::get('/dashboard_admin', myroute::API('UserController', 'dashboard'));
        
        // As0001VariabelsettingController
        Route::get('/variabel-setting', myroute::API('As0001VariabelsettingController', 'all'));
        Route::get('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'get'));
        Route::post('/variabel-setting', myroute::API('As0001VariabelsettingController', 'store'));
        Route::put('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'update'));
        Route::delete('/variabel-setting/{id}', myroute::API('As0001VariabelsettingController', 'delete'));

        //? As1001PesertaProfilController
        Route::get('/peserta', myroute::API('As1001PesertaProfilController', 'all'));
        Route::delete('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'delete'));

        //? As1002PesertaHasilnilaiController
        Route::get('/peserta/hasil-tes', myroute::API('As1001PesertaHasilnilaiController', 'all'));
        Route::delete('/peserta/hasil-tes/{id}', myroute::API('As1001PesertaHasilnilaiController', 'delete'));

        //? As2001KecermatanKolompertanyaanController
        Route::get('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'all'));
        Route::get('/kecermatan/kolompertanyaan/{val}', myroute::API('As2001KecermatanKolompertanyaanController', 'get'));
        Route::post('/kecermatan/kolompertanyaan', myroute::API('As2001KecermatanKolompertanyaanController', 'store'));
        Route::put('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'update'));
        Route::delete('/kecermatan/kolompertanyaan/{id}', myroute::API('As2001KecermatanKolompertanyaanController', 'delete'));

        //? As2002KecermatanSoaljawabanController
        Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'all'));
        Route::get('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'get'));
        Route::post('/kecermatan/soaljawaban/{id}', myroute::API('As2002KecermatanSoaljawabanController', 'store'));
        Route::put('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'update'));
        Route::delete('/kecermatan/soaljawaban/{id1}/{id2}', myroute::API('As2002KecermatanSoaljawabanController', 'delete'));
    });    
}

if(fun::getRawCookie('__token__')) {
    if(fun::getRawCookie('__unique__')) {
        Route::post('/peserta', myroute::API('As1001PesertaProfilController', 'store'));
        Route::get('/peserta/{no_identitas}', myroute::API('As1001PesertaProfilController', 'get'));
        Route::put('/peserta/{id}', myroute::API('As1001PesertaProfilController', 'update'));
        
        Route::get('/peserta/hasil-tes/{id}', myroute::API('As1001PesertaHasilnilaiController', 'get'));
        Route::post('/peserta/hasil-tes/{id}', myroute::API('As1001PesertaHasilnilaiController', 'store'));
        Route::put('/peserta/hasil-tes/{id}', myroute::API('As1001PesertaHasilnilaiController', 'update'));            
    }
}

Route::get('/hello', function(Request $request) {
    return 'hello '.gettype($request);
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

