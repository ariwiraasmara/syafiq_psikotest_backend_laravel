<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use App\Services\userService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;
class UserController extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    protected as1001_peserta_profilService $pesertaService;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService
        ) {
            $this->service = $service;
            $this->patService = $patService;
            $this->pesertaService = $pesertaService;
    }

    #POST
    public function login(Request $request): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);
            if($credentials) {
                $data = $this->service->login(fun::readable($request->email), fun::readable($request->password));
                if($data['success'] > 0) {
                    if (Auth::attempt($credentials, true)) {
                        $user = Auth::user();
                        Auth::login($user, true);
                        $path = '/';
                        $domain = 'psikotestasyik.com';
                        // $token = Crypt::encryptString($user->createToken($request->email, ['server:update'])->plainTextToken);
                        $pat = $this->patService->get(['name' => $request->email]);
                        $tokenExpire = fun::daysLater('+1 day');
                        $isTokenupdate = false;
                        if($pat[0]['expires_at'] == date('Y-m-d 00:00:00')) {
                            $this->patService->update($pat[0]['id'],[
                                'abilities' => '["*"]',
                                'expires_at' => $tokenExpire,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                            $this->service->updateRemembertoken($data['data'][0]['id'], fun::random('combwisp', 100));
                            $isTokenupdate = true;
                            return 1;
                        }
                        if(!$isTokenupdate) $tokenExpire = $pat[0]['expires_at'];
                        $token = fun::random('combwisp', 50);
                        $unique = fun::random('combwisp', 50);
                        $response = new Response([
                            'success' => 1,
                            'pesan'   => 'Yehaa! Berhasil Login!',
                            'data'    => [
                                'nama'    => $data['data'][0]['name'],
                                'email'   => $request->email,
                                'token_1' => Crypt::encryptString($pat[0]['id'].'|'.$pat[0]['token']),
                                'token_2' => $data['data'][0]['remember_token'],
                                'token_expire_at' => $tokenExpire
                            ],
                            'sesi'    => [
                                'expire_at'  => fun::daysLater('+12 hours'),
                                'sysel'      => Crypt::encryptString($request->email),
                                'sysauth'    => $unique,
                                'token'      => $token,
                                'unique'     => $unique,
                                'xsrf_token' => csrf_token(),
                            ]
                        ]);
                        $expirein = 6 * 60; // jam * menit
                        
                        $response->withCookie(cookie('islogin', true, $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('isadmin', true, $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('isauth', true, $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('__sysauth__', Crypt::encryptString($unique), $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('__token__', $token, $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('__unique__', $unique, $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('XSRF-TOKEN', csrf_token(), $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('email', $request->email, $expirein, $path, $domain, true, true, false, 'Strict'))
                                ->withCookie(cookie('nama', $data['data'][0]['name'], $expirein, $path, $domain, true, false, false, 'Strict'))
                                ->withCookie(cookie('personal_access_token', Crypt::encryptString($pat[0]['id'].'|'.$pat[0]['token']), $expirein, $path, $domain, true, true, false, 'Strict'))
                                ->withCookie(cookie('remember_token', Crypt::encryptString($data['data'][0]['remember_token']), $expirein, $path, $domain, true, true, false, 'Strict'));
                        return $response;
                    }
                }
                return match($data['error']){
                    1 => jsr::print([
                        'pesan' => 'Username / Email Salah!',
                        'error'=> 1
                    ], 'bad request'),
                    2 => jsr::print([
                        'pesan' => 'Password Salah!',
                        'error'=> 2
                    ],'bad request'),
                    default => jsr::print([
                        'pesan' => 'Terjadi Kesalahan!',
                        'error'=> -1
                    ])
                };
            }
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Is Not Valid!'
            ]);
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
    public function logout(Request $request): Response|JsonResponse|String|int|null {
        try {
            // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
            $domain = 'localhost';
            Auth::logout();
            fun::setCookieOff('islogin', true, $domain);
            fun::setCookieOff('isadmin', true, $domain);
            fun::setCookieOff('isauth', true, $domain);
            fun::setCookieOff('__sysel__', true, $domain);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Akhirnya Logout!',
                'sesi'    => [
                    'expire_at' => fun::daysLater('+6 hours')
                ]
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
    public function dashboard(Request $request): Response|JsonResponse|String|int|null {
        try {
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Dashboard!',
                'profil'  => fun::readable($request->header()['email'][0]),
                'data'    => $this->pesertaService->allLatest()
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
