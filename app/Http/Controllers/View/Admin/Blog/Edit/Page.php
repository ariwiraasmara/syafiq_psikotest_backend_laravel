<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Blog\Edit;
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
        $this->titlepage = 'Blog Baru | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : sepertinya mau mengubah data blog yang sudah ada?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/blog/edit/page', [
            'title'  => $this->titlepage,
            'token'  => csrf_token(),
            'unique' => $this->unique,
            'id'     => $this->id,
            'nama'   => $this->nama,
            'email'  => $this->email,
            'roles'  => $this->roles,
            'pat'    => $this->pat,
            'rtk'    => $this->rtk,
            'path'   => $this->path,
            'domain' => $this->domain
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return view('pages.admin.blog.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Blog Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/blog-baru',
            'navval'               => 'nav-admin-blog',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'id'                   => $id,
            'data'                 => $data[0]
        ]);
    }

    public function update(Request $request, $id) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_blog', ['sort' => 'title', 'by' => 'asc', 'search' => '-', 'page' => 1])->with('error', 'Unauthorized!');
            }
            if($request->status == 'public') {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'content'  => 'required',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            else {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            if($credentials) {
                $data = $this->service->update(fun::denval($id, true), [
                    'title'      => fun::readable($request->title),
                    'category'   => fun::readable($request->category),
                    'status'     => fun::readable($request->status),
                    'content'    => fun::readable($request->content),
                ]);
                if($data > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'edit and update : data blog yang sudah ada',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_blog', ['sort' => 'title', 'by' => 'asc', 'search' => '-', 'page' => 1]);
                }
                else {
                    return redirect()->route('admin_blog_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_blog_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Blog/Edit/Page => update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_blog_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
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
