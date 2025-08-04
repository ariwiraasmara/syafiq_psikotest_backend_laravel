<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Peserta\Edit;
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
use App\Services\as1001_peserta_profilService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
   //
    protected as1001_peserta_profilService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as1001_peserta_profilService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Edit Peserta | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : sepertinya mau mengubah data peserta yang sudah ada?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);
        $data = $this->service->get($id);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/peserta/edit/page', [
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
            'id_data' => $id,
            'data'    => $data[0]
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return view('pages.admin.peserta.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Peserta',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/peserta-edit',
            'navval'               => 'nav-admin-peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'id_data'              => $id,
            'data'                 => $data[0]
        ]);
    }

    public function update(Request $request, $id) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_peserta_detil', ['tgl1' => '-', 'tgl2' => '-', 'id' => $id])->with('error', 'Unauthorized!');
            }
            $credentials = $request->validate([
                'unique'    => 'required',
                'email'     => 'required|string',
                'tgl_lahir' => 'required|string',
                'asal'      => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->update(fun::denval($id, true), [
                    'email'         => fun::readable($request->email),
                    'tgl_lahir'     => fun::readable($request->tgl_lahir),
                    'asal'          => fun::readable($request->asal),
                ]);
                if($data > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'edit dan update : data peserta yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_peserta_detil', ['tgl1' => '-', 'tgl2' => '-', 'id' => $id]);
                }
                else {
                    return redirect()->route('admin_peserta_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_peserta_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Peserta/Edit/Page => update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_peserta_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
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
