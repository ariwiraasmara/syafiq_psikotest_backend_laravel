<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Blog;
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
use App\Services\as5001_blogService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller{
    //
    protected as5001_blogService|null $service;
    protected useractivitiesService|null $activity;
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
        $this->titlepage = 'Blog'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        // ?
        $this->id = $request->session()->get('id');
        $this->nama = $request->session()->get('nama');
        $this->email = $request->session()->get('email');
        $this->roles = $request->session()->get('roles');
        $this->pat = $request->session()->get('pat');
        $this->rtk = $request->session()->get('rtk');
        $this->filename = $request->session()->get('fileUDH');

        $this->activity->store([
            'id_user'    => $this->id,
            'ip_address' => $request->ip(),
            'path'       => $request->path(),
            'url'        => $request->fullUrl(),
            'page'       => $this->titlepage,
            'event'      => 'Web - '.$request->method(),
            'deskripsi'  => 'read : melihat semua data daftar blog.',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request): Inar|Response|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        return Inertia::render('admin/blog/page', [
            'title'      => $this->titlepage,
            'pathURL'    => url()->current(),
            'robots'     => $this->robots,
            'onetime'    => 1,
            'csrf_token' => csrf_token(),
            'unique'     => $this->unique,
            'id'         => $this->id,
            'nama'       => $this->nama,
            'email'      => $this->email,
            'roles'      => $this->roles,
            'pat'        => $this->pat,
            'rtk'        => $this->rtk,
            'path'       => $this->path,
            'domain'     => $this->domain
        ]);
    }

    public function bladeView(Request $request, $sort, $by, $search): View|Response|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];

        $data = $this->service->all($sort, $by, $search);
        $lastpage = 0;
        $fdata = null;
        if($data != null) {
            $fdata = $data['data'];
            $lastpage = $data['last_page'];
        }
        return view('pages.admin.blog.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Blog',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/',
            'navval'               => 'nav-admin-blog',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'data'                 => $fdata,
            'sort'                 => $sort,
            'by'                   => $by,
            'search'               => $search,
            'lastpage'             => $lastpage,
            'key'                  => fun::encrypt('@12!', 0),
            'page'                 => $page
        ]);
    }

    public function delete(Request $request, $id) {
        try {
            if($id) {
                $data = $this->service->get(fun::denval($id, true));
                $res = $this->service->softDelete(fun::denval($id, true));
                if($res > 0) {
                    $properties = collect([
                        'data' => $data,
                        'type' => 'soft delete',
                        'deleted_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'soft delete : menghapus data blog (soft).',
                        'properties' => $properties
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Blog',
                        'data'    => $res
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menghapus Data Blog',
                        'data'  => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Blog/Page => delete!', [
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
        $this->activity = null;
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
