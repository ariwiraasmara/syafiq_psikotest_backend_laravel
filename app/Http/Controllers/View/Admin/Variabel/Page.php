<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\as0001_variabelsettingService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as0001_variabelsettingService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as0001_variabelsettingService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Variabel Setting | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : melihat semua data daftar variabel setting.',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $sort, $by, $search): Inar|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/variabel/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $this->unique,
            'id'      => $this->id,
            'nama'    => $this->nama,
            'email'   => $this->email,
            'roles'   => $this->roles,
            'pat'     => $this->pat,
            'rtk'     => $this->rtk,
            'path'    => $this->path,
            'domain'  => $this->domain,
            'page'    => $page,
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
        return view('pages.admin.variabel.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Variabel Setting',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
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
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return jsr::print([
                    'error' => 3,
                    'pesan' => 'Unauthorized!',
                ], 'bad request');
            }
            if($id) {
                $data = $this->service->get(fun::denval($id, true));
                $res = $this->service->delete(fun::denval($id, true));
                if($res > 0) {
                    $properties = collect([
                        'data'       => $data,
                        'deteled_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'delete : menghapus data variabel setting',
                        'properties' => $properties
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Setting Variabel',
                        'data'    => $data
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 2,
                        'pesan' => 'Gagal Menghapus Data Setting Variabel',
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Variabel/Page => delete!', [
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
