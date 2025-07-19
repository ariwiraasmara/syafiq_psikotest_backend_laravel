<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Services\userService;
use App\Services\useractivitiesService;
use App\Services\userdevicehistoryService;
use App\Services\userdeviceloggingService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class UserController extends Controller {
    //
    protected userService|null $service;
    protected useractivitiesService|null $activity;
    protected userdevicehistoryService|null $devicehistory;
    protected userdeviceloggingService|null $devicelogging;
    protected personalaccesstokensService|null $patService;
    protected as1001_peserta_profilService|null $pesertaService;
    protected $titlepage, $path, $domain, $unique;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService,
        useractivitiesService $activity,
        userdevicehistoryService $devicehistory,
        userdeviceloggingService $devicelogging
    ) {
        // ?
        $this->service = $service;
        $this->patService = $patService;
        $this->pesertaService = $pesertaService;
        $this->activity = $activity;
        $this->devicehistory = $devicehistory;
        $this->devicelogging = $devicelogging;

        // ?
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);

        // ?

    }

    public function all(Request $request): Response|JsonResponse|String|int|null {
        try {

        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->all!', [
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

    public function allWithSearch(Request $request) : Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->allWithSearch!', [
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

    public function get(Request $request) : Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->get!', [
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

    public function detail(Request $request) : Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->detail!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print(
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }

    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->store!', [
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

    public function updateAccount(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateAccount!', [
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

    public function updatePassword(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updatePassword!', [
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

    public function updateRemembertoken(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateRemembertoken!', [
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

    public function updatePAT(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updatePAT!', [
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

    public function updateProfil(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateProfil!', [
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

    public function updateFoto(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateFoto!', [
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

    public function softDelete(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->softDelete!', [
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

    public function hardDelete(Request $request): Response|JsonResponse|String|int|null {
        try {
            
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->hardDelete!', [
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

    #POST
    #url = '/api/login/';
    public function login(Request $request): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);
            if($credentials) {
                $login_at = date('Y-m-d H:i:s');
                $filename = date('Ymd');
                $data = $this->service->login([
                    'email'      => fun::readable($request->email),
                    'pass'       => fun::readable($request->password),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('user-agent'),
                    'login_at'   => $login_at,
                    'filename'   => $filename
                ]);
                if($data['success'] > 0) {
                    if(Auth::attempt($credentials, true)) {
                        $user = Auth::user();
                        Auth::login($user, true);
                        // $token = fun::encrypt($user->createToken($request->email, ['server:update'])->plainTextToken);
                        $pat = $this->patService->get(['name' => $request->email]);
                        $tokenExpire = $pat[0]['expires_at'];
                        if($pat[0]['expires_at'] == date('Y-m-d 00:00:00')) {
                            $this->patService->update($pat[0]['id'],[
                                'last_used_at'  => now(),
                                'expires_at'    => fun::daysLater('+7 days'),
                                'updated_at'    => date('Y-m-d H:i:s')
                            ]);
                            $this->service->updateRemembertoken($data['data'][0]['id'], fun::random('combwisp', 100));
                        }
                        else {
                            $this->patService->update($pat[0]['id'],[
                                'last_used_at' => now()
                            ]);
                        }
                        $unique = fun::random('combwisp', 40);
                        $token = fun::random('combwisp', 40);
                        $sysauth = fun::random('combwisp', 100);
                        $expirein = 6 * 60; // jam * menit

                        $rfdt = [
                            'success' => 1,
                            'pesan'   => 'Yehaa! Berhasil Login!',
                            'data'    => [
                                'nama'    => $data['data'][0]['name'],
                                'email'   => $request->email,
                                '__pas-tyv__' => fun::encrypt($pat[0]['id'].'|'.$pat[0]['token']),
                                '__pas-qpv' => $data['data'][0]['remember_token'],
                            ],
                            'sesi'    => [
                                'expire_at' => $tokenExpire,
                                'sysel'     => fun::encrypt($request->email),
                                'sysauth'   => $unique,
                                'token1'    => $token,
                                'token2'    => csrf_token(),
                                'unique'    => $unique,
                            ]
                        ];

                        $this->activity->store([
                            'id_user'    => $data['data'][0]['id'],
                            'ip_address' => $request->ip(),
                            'path'       => $request->path(),
                            'url'        => $request->fullUrl(),
                            'page'       => $this->titlepage,
                            'event'      => $request->method(),
                            'deskripsi'  => 'login : masuk sistem admin user : '.$data['data'][0]['name'],
                            'properties' => json_encode($request->all())
                        ]);

                        $request->authenticate();
                        $request->session()->regenerate();
                        $response = new Response($rfdt);

                        return $response
                                ->cookie('_pas-g1', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-m2', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-t3', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-x4', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-m5', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-sys', $sysauth, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-kn', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-nq', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
                    }
                }
                else {
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
            }
            else {
                return jsr::print([
                    'error'=> -13,
                    'pesan' => 'Is Not Valid!'
                ]);
            }
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

    public function __destruct() {
        $this->service          = null;
        $this->patService       = null;
        $this->pesertaService   = null;
        $this->activity         = null;
        $this->devicehistory    = null;
        $this->devicelogging    = null;
    }
}
