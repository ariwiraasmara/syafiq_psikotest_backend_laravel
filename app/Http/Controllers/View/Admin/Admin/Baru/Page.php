<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin\Admin\Baru;
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
use App\Services\userService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected userService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        userService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Admin Baru | Admin'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'none, nosnippet, noarchive, notranslate, noimageindex';

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
            'deskripsi'  => 'read : sepertinya mau menambah data admin baru?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/admin/baru/page', [
            'title'    => $this->titlepage,
            'token'    => csrf_token(),
            'unique'   => $unique,
            'id'       => $this->id,
            'nama'     => $this->nama,
            'email'    => $this->email,
            'roles'    => $this->roles,
            'pat'      => $this->pat,
            'rtk'      => $this->rtk,
            'path'     => $this->path,
            'domain'   => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.admin.baru.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Admin Baru',
            'pathURL'              => url()->current(),
            'robots'               => $this->robots,
            'onetime'              => false,
            'breadcrumb'           => '/admin/baru',
            'navval'               => 'nav-admin-baru',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
        ]);
    }

    public function store(Request $request) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-', 'page' => 1])->with('error', 'Unauthorized!');
            }
            $credentials = $request->validate([
                'unique'        => 'required',
                'name'          => 'required|string',
                'email'         => 'required|string',
                'no_identitas'  => 'required|string',
                'roles'         => 'required',
                'jk'            => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'name'          => fun::escape($request->name),
                    'email'         => fun::escape($request->email),
                    'no_identitas'  => fun::escape($request->no_identitas),
                    'roles'         => fun::escape($request->roles),
                    'jk'            => fun::escape($request->jk),
                    'alamat'        => fun::escape($request->alamat),
                    'status'        => fun::escape($request->status),
                    'agama'         => fun::escape($request->agama),
                    'foto'          => fun::escape($request->foto)
                ]);
                if($data > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'create and store : data admin baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_anggota', ['sort' => 'name', 'by' => 'asc', 'search' => '-', 'page' => 1]);
                }
                else {
                    return redirect()->route('admin_anggota_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_anggota_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Admin/Baru/Page => store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_anggota_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
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
