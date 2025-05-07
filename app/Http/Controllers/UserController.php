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
use Illuminate\Support\Facades\Cookie;
use Exception;
class UserController extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    protected as1001_peserta_profilService $pesertaService;
    protected $path, $domain;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService
        ) {
            $this->service = $service;
            $this->patService = $patService;
            $this->pesertaService = $pesertaService;
            $this->path = env('SESSION_PATH', '/');
            $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    #POST
    #url = '/api/login/';
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
                        // $token = Crypt::encryptString($user->createToken($request->email, ['server:update'])->plainTextToken);
                        $pat = $this->patService->get(['name' => $request->email]);
                        $tokenExpire = fun::daysLater('+1 day');
                        $isTokenupdate = false;
                        $expirein = 6 * 60; // jam * menit
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
                            ],
                            'copyright @' => [
                                'Year'  => date('Y'),
                                '1' => [
                                    'nama' => 'Syafiq',
                                    'email' => 'syafiq@gmail.com',
                                    'sebagai' => 'owner'
                                ],
                                '2' => [
                                    'nama' => 'Syahri Ramadhan Wiraasmara',
                                    'email' => 'ariwiraasmara.sc37@gmail.com',
                                    'sebagai' => 'developer'
                                ]
                            ]
                        ]);

                        return $response
                                ->cookie('email', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('nama', $data['data'][0]['name'], $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                // ->cookie('pat', fun::enval($pat[0]['id'].'|'.$pat[0]['token'], true), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                // ->cookie('rtk', fun::enval($data['data'][0]['remember_token'], true), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('islogin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('isadmin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('isauth', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('expire_at', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('__sysauth__', Crypt::encryptString($unique), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('__token__', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('__unique__', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
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
    #url = '/api/logout/'
    public function logout(Request $request): Response|JsonResponse|String|int|null {
        try {
            Auth::logout();
            $response = new Response([
                'success' => 1,
                'pesan'   => 'Akhirnya Logout!',
                'sesi'    => [
                    'expire_at' => fun::daysLater('+6 hours')
                ]
            ]);
            return $response->cookie('email', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('nama', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('islogin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('isadmin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('isauth', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__sysauth__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__token__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__unique__', null, -1, $this->path, $this->domain, true, true, false, 'Strict');
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
    #url = '/api/dashboard_admin/'
    public function dashboard(Request $request): Response|JsonResponse|String|int|null {
        try {
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Dashboard!',
                'profil'  => fun::readable($request->cookie('nama')).', '.fun::readable($request->cookie('email')),
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
