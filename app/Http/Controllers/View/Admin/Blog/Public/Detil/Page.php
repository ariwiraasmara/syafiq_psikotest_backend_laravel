<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Blog\Public\Detil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\userdeviceloggingService;
use App\Services\as5001_blogService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as5001_blogService|null $service;
    protected useractivitiesService|null $activity;
    protected userdeviceloggingService $udl;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as5001_blogService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = ' | Blog'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        // ?
        // ?
        if($request->session()->has('nama')) $this->nama = $request->session()->get('nama');
        else $this->nama = null;

        if($request->session()->has('email')) $this->email = $request->session()->get('email');
        else $this->email = null;

        if($request->session()->has('roles')) $this->roles = $request->session()->get('roles');
        else $this->roles = null;

        if($request->session()->has('pat')) $this->pat = $request->session()->get('pat');
        else $this->pat = null;

        if($request->session()->has('rtk')) $this->rtk = $request->session()->get('rtk');
        else $this->rtk = null;

        if($request->session()->has('fileUDH')) $this->filename = $request->session()->has('fileUDH');
        else $this->filename = date('Ymd');

        if($request->session()->has('id')) {
            $this->id = $request->session()->get('id');
            $this->activity->store([
                'id_user'    => $this->id,
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $this->titlepage,
                'event'      => 'Web - '.$request->method(),
                'deskripsi'  => 'read : melihat data blog detil yang terpublikasi ke seluruh dunia.',
                'properties' => json_encode($request->all())
            ]);
        }
        else {
            $this->id = 0;
            $this->udl = new userdeviceloggingService(
                0, date('Ymd'),
                [
                    'tanggal'       => date('Y-m-d H:i:s'),
                    'host'          => $request->host(),
                    'id_user'       => 0,
                    'nama'          => 'Tamu',
                    'email'         => '-',
                    'roles_user'    => 0,
                    'ip_address'    => $request->ip(),
                ],
                [
                    'last_path'     => $request->path(),
                    'last_url'      => $request->fullUrl(),
                    'last_page'     => $this->titlepage,
                    'method_page'   => 'Web - '.$request->method(),
                    'deskripsi'     => 'read : melihat data blog detil yang terpublikasi ke seluruh dunia.',
                    'body_content'  => json_encode($request->all())
                ]
            );
        }
    }

    public function reactView(Request $request, $title): Inar|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->publicDetail($title);

        meta()->title($title.$this->titlepage)
            ->set('og:title', $title.$this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $$this->unique);

        return Inertia::render('admin/blog/public/detil/page', [
            'title'                => $title.$this->titlepage,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/blog/'.$title,
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => 1,
            'csrf_token'           => csrf_token(),
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'pat'                  => $this->pat,
            'rtk'                  => $this->rtk,
            'path'                 => $this->path,
            'domain'               => $this->domain
        ]);
    }

    public function bladeView(Request $request, $title): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->publicDetail($title);
        return view('pages.admin.blog.public.detil.page', [
            'title'                => $title.$this->titlepage,
            'appbar_title'         => $title,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/blog/'.$title,
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'data'                 => $data[0],
        ]);
    }

    public function __destruct() {
        if($this->id > 0) $this->activity = null;
        else $this->udl->print();
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
