<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Layanan;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\userdeviceloggingService;
use App\Libraries\branding;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected useractivitiesService|null $activity;
    protected userdeviceloggingService $udl;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $robots;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $headerLog, $activitiesLog;
    public function __construct(
        Request $request,
        branding $brand,
        useractivitiesService $activity
    ) {
        $this->brand = $brand;
        $this->activity = $activity;

        $this->titlepage = 'Layanan'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        if($request->session()->has('id')) {
            $this->id = $request->session()->get('id');

            $this->activity->store([
                'id_user'    => $this->id,
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $this->titlepage,
                'event'      => 'Web - '.$request->method(),
                'deskripsi'  => 'read : halaman layanan',
                'properties' => json_encode($request->all())
            ]);
        }
        else $this->id = 0;

        if($request->session()->has('nama')) $this->nama = $request->session()->get('nama');
        else $this->nama = null;

        if($request->session()->has('email')) $this->email = $request->session()->get('email');
        else $this->email = null;

        if($request->session()->has('roles')) $this->roles = $request->session()->get('roles');
        else $this->roles = null;

        if($request->session()->has('fileUDH')) $this->filename = $request->session()->has('fileUDH');
        else $this->filename = date('Ymd');

        $this->headerLog = [
            'tanggal'       => date('Y-m-d H:i:s'),
            'host'          => $request->host(),
            'id_user'       => $this->id,
            'nama'          => $this->nama,
            'email'         => $this->email,
            'roles_user'    => $this->roles,
            'ip_address'    => $request->ip(),
        ];

        $this->activitiesLog = [
            'id_user'       => $this->id,
            'last_path'     => $request->path(),
            'last_url'      => $request->fullUrl(),
            'last_page'     => $this->titlepage,
            'method_page'   => 'Web - '.$request->method(),
            'deskripsi'     => 'read : halaman layanan',
            'body_content'  => json_encode($request->all())
        ];

        $this->udl = new userdeviceloggingService(
            $this->id,
            $this->filename,
            $this->headerLog,
            $this->activitiesLog
        );
    }

    public function reactView(Request $request): Inar|Response|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        return Inertia::render('layanan/page', [
            'title'      => $this->titlepage,
            'pathURL'    => url()->current(),
            'robots'     => $this->robots,
            'onetime'    => 1,
            'csrf_token' => csrf_token(),
            'unique'     => $this->unique,
            'path'       => $this->path,
            'domain'     => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.layanan.page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
            'ispeserta'            => false,
            'path'                 => $this->path,
            'domain'               => $this->domain,
        ]);
    }

    public function __destruct() {
        $this->udl->print($this->activitiesLog);
        $this->titlepage = null;
        $this->path = null;
        $this->domain = null;
        $this->unique = null;
        $this->robots = null;
        $this->id = null;
        $this->nama = null;
        $this->email = null;
        $this->roles = null;
    }
}
