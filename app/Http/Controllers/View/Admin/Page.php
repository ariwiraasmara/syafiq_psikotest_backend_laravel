<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use App\Models\User;
use App\Services\useractivitiesService;
use App\Services\userdeviceloggingService;
use App\Services\userService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected User|null $model;
    protected userService|null $service;
    protected personalaccesstokensService|null $patService;
    protected as1001_peserta_profilService|null $pesertaService;
    protected userdeviceloggingService $udl;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    protected $headerLog, $activitiesLog;
    public function __construct(
        Request $request,
        branding $brand,
        User $model,
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService,
        useractivitiesService $activity
    ) {
        // ?
        $this->model = $model;
        $this->service = $service;
        $this->patService = $patService;
        $this->pesertaService = $pesertaService;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Login'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        // ?
        $this->headerLog = [
            'tanggal'       => date('Y-m-d H:i:s'),
            'host'          => $request->host(),
            'id_user'       => 0,
            'nama'          => 'Tamu',
            'email'         => '-',
            'roles_user'    => 0,
            'ip_address'    => $request->ip(),
        ];

        $this->activitiesLog = [
            'id_user'       => $this->id,
            'last_path'     => $request->path(),
            'last_url'      => $request->fullUrl(),
            'last_page'     => $this->titlepage,
            'method_page'   => 'Web - '.$request->method(),
            'deskripsi'     => 'read : halaman login admin. sepertinya mau login?',
            'body_content'  => json_encode($request->all())
        ];

        $this->udl = new userdeviceloggingService(
            $this->id,
            date('Ymd'),
            $this->headerLog,
            $this->activitiesLog
        );
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        if( isset($_COOKIE['_pas-g1']) &&
            isset($_COOKIE['_pas-m2']) &&
            isset($_COOKIE['_pas-t3']) &&
            $request->session()->has('id')
        ) {
            return redirect()->route('admin_dashboard');
        }

        $date = date('d');
        if( ($date == 1) || ($date == 16) ) {
            if(!$request->session()->has('is_generatate_sitemap') || now()->greaterThanOrEqualTo($request->session()->get('is_generatate_sitemap_expiry'))) {
                return redirect()->route('generate_sitemap');
            }
        }
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        return Inertia::render('admin/page', [
            'title'       => $this->titlepage,
            'csrf_token'  => csrf_token(),
            'unique'      => $this->unique,
            'route_login' => route('admin_login', ['type'=>'js']),
            'path'        => $this->path,
            'domain'      => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        if( isset($_COOKIE['_pas-g1']) &&
            isset($_COOKIE['_pas-m2']) &&
            isset($_COOKIE['_pas-t3']) &&
            $request->session()->has('id')
        ) {
            return redirect()->route('admin_dashboard');
        }

        $date = date('d');
        if( ($date == 1) || ($date == 15) ) {
            if(!$request->session()->has('is_generatate_sitemap') || now()->greaterThanOrEqualTo($request->session()->get('is_generatate_sitemap_expiry'))) {
                return redirect()->route('generate_sitemap');
            }
        }

        $try_login = 0;
        if(Cache::has('try_login')) {
            $try_login = Cache::get('try_login');
        }

        return view('pages.admin.page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'robots'               => $this->robots,
            'onetime'              => true,
            'breadcrumb'           => '/admin',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => $this->unique,
            'try_login'            => $try_login
        ]);
    }

    #POST
    public function login(Request $request, $type) {
        try {
            // if(date('Y-m-d H:i:s') > $request->cookie('_pas-g1')) {
                $credentials = $request->validate([
                    'email'     => 'required|string',
                    'password'  => 'required|string',
                ]);
                if($credentials) {
                    $try_login = null;
                    if(Cache::has('try_login')) {
                        $try_login = Cache::get('try_login');

                        if($try_login['retry'] > 2) {
                            $waiting_time = $try_login['waiting_time'];
                            return redirect('/admin')->with('error', "Terlalu banyak percobaan login. Coba lagi setelah $waiting_time detik.");
                        }
                    }

                    $login_at = date('Y-m-d H:i:s');
                    $filename = date('Ymd');
                    $data = $this->service->login([
                        'email'      => fun::escape($request->email),
                        'pass'       => fun::escape($request->password),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('user-agent'),
                        'login_at'   => $login_at,
                        'filename'   => $filename
                    ]);
                    if($data['success'] > 0) {
                        if(Auth::attempt($credentials, true)) {
                            $user = Auth::user();
                            Auth::login($user, true);
                            $userDetil = $this->service->profil($data['data'][0]['id']);
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

                            $profil = [
                                'id'           => $data['data'][0]['id'],
                                'nama'         => $data['data'][0]['name'],
                                'email'        => $data['data'][0]['email'],
                                'roles'        => $data['data'][0]['roles'],
                                'no_identitas' => $userDetil[0]['no_identitas'],
                                'foto'         => $userDetil[0]['foto'],
                                'admin'        => 1,
                            ];
    
                            $jwt =  Crypt::encrypt(fun::enval(Crypt::encrypt($pat), true));
                            $rememberToken = fun::enval($data['data'][0]['remember_token'], true);
    
                            $rfdt = [
                                'success' => 1,
                                'pesan'   => 'Yehaa! Berhasil Login!',
                                'data'    => [
                                    'pas_bah' => fun::enval(Crypt::encrypt($profil), true),
                                    'pas_tit' => $jwt,
                                    'pas_tek' => $rememberToken,
                                ],
                                'sesi'    => [
                                    'expire_at'   => $tokenExpire,
                                    'pas_sisis'   => fun::encrypt($request->email),
                                    'pas_ukulele' => $unique,
                                    'pas_tkesdeh' => $token,
                                    'pas_tkempeh' => csrf_token(),
                                    'pas_qiqi'    => $unique,
                                ]
                            ];

                            $request->session()->put('id', $data['data'][0]['id']);
                            $request->session()->put('email', $request->email);
                            $request->session()->put('nama', $data['data'][0]['name']);
                            $request->session()->put('roles', $data['data'][0]['roles']);
                            $request->session()->put('pat', $jwt);
                            $request->session()->put('rtk', $data['data'][0]['remember_token']);
                            $request->session()->put('fileUDH', $data['data'][0]['id'].'.'.$request->email.'/'.$filename);

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

                            if($type == 'php') {
                                return redirect('admin/dashboard')
                                    ->cookie('_pas-g1', 1, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-m2', 1, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-t3', 1, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-x4', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-m5', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-sys', $sysauth, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-kn', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('_pas-nq', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
                            }
                            else if($type == 'js') {
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
                            return redirect('/admin')->with('error', 'Terjadi Kesalahan! Authentication Error!');
                        }
                    }
                    else {
                        // Jika login gagal, simpan percobaan login
                        if($try_login === null) {
                            $try_login = [
                                'ip_address'   => $request->ip(),
                                'retry'        => 1,
                            ];
                            Cache::put('try_login', $try_login, 300);
                            if($try_login['retry'] > 2) {
                                $try_login = [
                                    'ip_address'   => $request->ip(),
                                    'retry'        => 3,
                                    'waiting_time' => 12 * 24 * 60 * 60 // waktu tunggu dalam detik
                                ];
                                Cache::put('try_login', $try_login, 12 * 24 * 60 * 60);
                                $waiting_time = $try_login['waiting_time'];
                                return redirect('/admin')->with('error', "Terlalu banyak percobaan login. Coba lagi setelah $waiting_time detik.");
                            }
                        }
                        else {
                            $try_login['retry']++;
                            Cache::put('try_login', $try_login, 300);
                        }

                        // if(Cache::has('try_login')) {
                        //     $try_login = Cache::get('try_login');
                        //     Cache::put('try_login', $try_login + 1, now()->addMinutes(5));
                        // }

                        return redirect('/admin')->with('error', 'Terjadi Kesalahan! Email/Password Salah! Silahkan Coba Lagi!');
                    }
                }
                else {
                    return redirect('/admin')->with('error', 'Invalid Credentials!');
                }
            // }
            // else {
            //     return redirect('/admin')->with('error', 'Sesi Anda Telah Berakhir!<br/><br/>Terakhir Login: <b>'.$request->cookie('expire_at').'</b><br/><br/>Datang dan Login Kembali Setelah : <b>'.$request->cookie('expire_at').'</b><br/><br/>Kami mohon maaf atas ketidaknyamanan ini dan menghargai pengertian Anda.');
            // }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada User/Admin/Page => login!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin')->with('error', 'Terjadi Kesalahan!!!');
        }
    }

    public function __destruct() {
        $this->udl->print($this->activitiesLog);
        $this->service   = null;
        $this->data      = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
        $this->robots    = null;
        $this->data      = null;
        $this->id        = null;
        $this->nama      = null;
        $this->email     = null;
        $this->roles     = null;
        $this->filename  = null;
    }
}