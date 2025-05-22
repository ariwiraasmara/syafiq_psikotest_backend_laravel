<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\userService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    protected as1001_peserta_profilService $pesertaService;
    protected $titlepage, $path, $domain;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService
        ) {
            $this->service = $service;
            $this->patService = $patService;
            $this->pesertaService = $pesertaService;
            $this->titlepage = 'Login | Psikotest Online App';
            $this->path = env('SESSION_PATH', '/');
            $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        if( isset($_COOKIE['islogin']) &&
            isset($_COOKIE['isadmin']) &&
            isset($_COOKIE['isauth'])
        ) {
            return redirect()->route('admin_dashboard');
        }

        $date = date('d');
        if( ($date == 1) || ($date == 16) ) {
            if(!$request->session()->has('is_generatate_sitemap') || now()->greaterThanOrEqualTo($request->session()->get('is_generatate_sitemap_expiry'))) {
                return redirect('/generate-sitemap');
            }
        }

        $unique = fun::random('combwisp', 50);
        // Cookie::queue('XSRF-TOKEN', csrf_token(), 6 * 60, $this->path, $this->domain, true, true, false, 'None');

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        return Inertia::render('admin/page', [
            'title'       => $this->titlepage,
            'csrf_token'  => csrf_token(),
            'unique'      => $unique,
            'route_login' => route('admin_login', ['type'=>'js']),
            'path'        => $this->path,
            'domain'      => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        if( isset($_COOKIE['islogin']) &&
            isset($_COOKIE['isadmin']) &&
            isset($_COOKIE['isauth'])
        ) {
            return redirect()->route('admin_dashboard');
        }
        
        $date = date('d');
        if( ($date == 1) || ($date == 16) ) {
            if(!$request->session()->has('is_generatate_sitemap') || now()->greaterThanOrEqualTo($request->session()->get('is_generatate_sitemap_expiry'))) {
                return redirect('/generate-sitemap');
            }
        }
        return view('pages.admin.page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => true,
            'breadcrumb'           => '/admin',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => fun::random('combwisp', 50)
        ]);
    }

    #POST
    public function login(Request $request, $type) {
        try {
            // if(date('Y-m-d H:i:s') > $request->cookie('expire_at')) {
                $credentials = $request->validate([
                    'email'     => 'required|string',
                    'password'  => 'required|string',
                ]);
                if($credentials) {
                    $data = $this->service->login(fun::readable($request->email), fun::readable($request->password));
                    if($data['success'] > 0) {
                        if(Auth::attempt($credentials, true)) {
                            $user = Auth::user();
                            Auth::login($user, true);
                            // $token = fun::encrypt($user->createToken($request->email, ['server:update'])->plainTextToken);
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
                                    'token_1' => fun::encrypt($pat[0]['id'].'|'.$pat[0]['token']),
                                    'token_2' => $data['data'][0]['remember_token'],
                                    // 'token_expire_at' => $tokenExpire
                                ],
                                'sesi'    => [
                                    'expire_at' => fun::daysLater('+12 hours'),
                                    'sysel'     => fun::encrypt($request->email),
                                    'sysauth'   => $unique,
                                    'token1'    => $token,
                                    'token2'    => csrf_token(),
                                    'unique'    => $unique,
                                ]
                            ];

                            $request->session()->put('email', $request->email);
                            $request->session()->put('nama', $data['data'][0]['name']);
                            $request->session()->put('pat', fun::encrypt($pat[0]['id'].'|'.$pat[0]['token']));
                            $request->session()->put('rtk', $data['data'][0]['remember_token']);

                            // Cookie::queue('islogin', true, $expirein, $path, $domain, true, true, false, 'None');
                            // Cookie::queue('isadmin', true, $expirein, $path, $domain, true, true, false, 'None');
                            // Cookie::queue('isauth', true, $expirein, $path, $domain, true, true, false, 'None');
                            // Cookie::queue('expire_at', fun::daysLater('+12 hours'), $expirein, $path, $domain, true, true, false, 'None');
                            
                            // return redirect()->route('admin_dashboard')
                            if($type == 'php') {
                                return redirect('admin/dashboard')
                                    ->cookie('islogin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('isadmin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('isauth', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('expire_at', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('email', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('__sysauth__', $sysauth, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('__token__', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('__unique__', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                    ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
                            }
                            else if($type == 'js') {
                                $response = new Response($rfdt);
                                return $response
                                        // ->cookie('islogin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        // ->cookie('isadmin', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        // ->cookie('isauth', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('expire_at', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('email', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('__sysauth__', $sysauth, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('__token__', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('__unique__', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                        ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
                            }
                        }
                        else {
                            return redirect('/admin')->with('error', 'Terjadi Kesalahan! Authentication Error!');
                        }
                    }
                    else {
                        return redirect('/admin')->with('error', 'Terjadi Kesalahan! Email/Password Salah! Silahkan Coba Lagi!');
                    }
                }
                else {
                    return redirect('/admin')->with('error', 'Terjadi Kesalahan!');
                }
            // }
            // else {
            //     return redirect('/admin')->with('error', 'Sesi Anda Telah Berakhir!<br/><br/>Terakhir Login: <b>'.$request->cookie('expire_at').'</b><br/><br/>Datang dan Login Kembali Setelah : <b>'.$request->cookie('expire_at').'</b><br/><br/>Kami mohon maaf atas ketidaknyamanan ini dan menghargai pengertian Anda.');
            // }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->login!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin')->with('error', 'Terjadi Kesalahan!!!');
        }
    }
}
