<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin\Blog\Public;
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
    protected $headerLog, $activitiesLog;
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
        $this->titlepage = 'Blog'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

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
                'deskripsi'  => 'read : melihat semua data blog yang terpublikasi ke seluruh dunia.',
                'properties' => json_encode($request->all())
            ]);
        }
        else {
            $this->id = 0;

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
                'id_user'       => 0,
                'last_path'     => $request->path(),
                'last_url'      => $request->fullUrl(),
                'last_page'     => $this->titlepage,
                'method_page'   => 'Web - '.$request->method(),
                'deskripsi'       => 'read : melihat semua data blog yang terpublikasi ke seluruh dunia.',
                'body_content'  => json_encode($request->all())
            ];

            $this->udl = new userdeviceloggingService(
                0, date('Ymd'), $this->headerLog, $this->activitiesLog
            );
        }
    }

    public function reactView(Request $request): Inar|Response|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);
        $data = $this->service->publicAll();
        $this->titlepage = $data[0]['title'];

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        return Inertia::render('admin/blog/public/page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/blog',
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

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        $page = @$_GET['page'];
        if(isset($_GET['cari'])) {
            $data = $this->service->publicSearch('title', @$_GET['cari']);
            $link_page_change = route('blog').'?cari='.@$_GET['cari'].'&page='.$page;
        }
        else if(isset($_GET['kategori'])) {
            $data = $this->service->publicSearch('category', @$_GET['kategori']);
            $link_page_change = route('blog').'?kategori='.@$_GET['kategori'].'&page='.$page;
        }
        else {
            $data = $this->service->publicAll();
            $link_page_change = route('blog').'?page='.$page;
        }

        $lastpage = 0;
        $fdata = null;
        if($data != null) {
            $fdata = $data['data'];
            $lastpage = $data['last_page'];
        }
        return view('pages.admin.blog.public.page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/blog',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'path'                 => $this->path,
            'domain'               => $this->domain,
            'data'                 => $fdata,
            'lastpage'             => $lastpage,
            'key'                  => fun::encrypt('@12!', 0),
            'page'                 => $page,
            'link_page_change'     => $link_page_change
        ]);
    }

    public function __destruct() {
        if($this->id > 0) {
            $this->activity = null;
        }
        else $this->udl->print($this->activitiesLog);
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
