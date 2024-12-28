<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use App\Services\userService;
use App\Services\personalaccesstokensService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService) {
            $this->service = $service;
            $this->patService = $patService;
    }

    #POST
    public function login(Request $request): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->login($request->email, $request->password);
            if($data['success']) {
                $credentials = $request->validate([
                    'email'     => ['required'],
                    'password'  => ['required'],
                ]);
                if (Auth::attempt($credentials)) {
                    $path = '/';
                    $domain = 'localhost';
                    // $token = fun::encrypt($user->createToken($request->email, ['server:update'])->plainTextToken);
                    $pat = $this->patService->get(['name' => $request->email]);
                    $tokenExpire = fun::daysLater('+7 days');
                    $isTokenupdate = false;
                    if($pat[0]['expires_at'] == date('Y-m-d 00:00:00')) {
                        $this->patService->update($pat[0]['id'],[
                            'abilities' => '["*"]',
                            'expires_at' => $tokenExpire,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        $this->service->updateRemembertoken($data['data'][0]['id'], fun::random('combwisp', 50));
                        $isTokenupdate = true;
                        return 1;
                    }
                    if(!$isTokenupdate) $tokenExpire = $pat[0]['expires_at'];
                    $response = new Response([
                        'success' => 1,
                        'pesan'   => 'Yehaa! Berhasil Login!',
                        'data'    => [
                            'nama'    => $data['data'][0]['name'],
                            'email'   => $request->email,
                            'token_1' => fun::encrypt($pat[0]['id'].'|'.$pat[0]['token']),
                            'token_2' => $data['data'][0]['remember_token'],
                            'token_expire_at' => $tokenExpire
                        ]
                    ]);
                    $response->withCookie(cookie('islogin', true, 60));
                    $response->withCookie(cookie('isadmin', true, 60));
                    $response->withCookie(cookie('__sysel__', $request->email, 60));
                    return $response;
                }
            }
            return match($data->get('error')){
                1 => jsr::print([
                    'pesan' => 'Username / Email Salah!',
                    'error'=> 1], 'bad request'),
                2 => jsr::print([
                    'pesan' => 'Password Salah!',
                    'error'=> 2],'bad request'),
                default => jsr::print([
                    'pesan' => 'Terjadi Kesalahan!',
                    'error'=> -1])
            };
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->login!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }

    #GET
    public function logout(): Response|JsonResponse|String|int|null {
        try {
            // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
            $domain = 'localhost';
            Auth::logout();
            fun::setCookieOff('islogin', true, $domain);
            fun::setCookieOff('isadmin', true, $domain);
            fun::setCookieOff('__sysel__', true, $domain);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Akhirnya Logout!'
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->logout!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }

    #GET
    public function dashboard(Request $request) {
        try {
            if(Cache::has('page-dashboard')) $data = Cache::get('page-dashboard');
            else {
                Cache::put('page-dashboard', $this->service->dashboard($request->header()['email'][0]), 1*6*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
                $data = Cache::get('page-dashboard');
            };
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Dashboard!',
                'data'      => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->dashboard!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }
}
