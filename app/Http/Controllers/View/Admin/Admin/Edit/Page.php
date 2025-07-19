<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Admin\Edit;
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
        $this->titlepage = 'Edit Admin | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : sepertinya mau mengubah data admin yang sudah ada?',
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

        return Inertia::render('admin/admin/edit/page', [
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

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->detail('id', fun::denval($id, true));
        $filtered_data_edit = [
            'nama'         => $data['user'][0]['name'],
            'email'        => $data['user'][0]['email'],
            'roles'        => $data['user'][0]['roles'],
            'no_identitas' => $data['user'][0]['no_identitas'],
            'jk'           => $data['user'][0]['jk'],
            'status'       => $data['user'][0]['status'],
            'agama'        => $data['user'][0]['agama'],
            'alamat'       => $data['user'][0]['alamat'],
        ];
        return view('pages.admin.admin.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Admin',
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
            'id_data'              => $id,
            'data'                 => $filtered_data_edit
        ]);
    }

    public function update(Request $request, $id) {
        try {
            $credentials = $request->validate([
                'unique'        => 'required',
                'no_identitas'  => 'required',
                'roles'         => 'required',
                'jk'            => 'required',
            ]);
            if($credentials) {
                $data2 = $this->service->updateProfil(fun::denval($id, true), [
                    'no_identitas'  => $request->no_identitas,
                    'jk'            => $request->jk,
                    'alamat'        => $request->alamat,
                    'status'        => $request->status,
                    'agama'         => $request->agama,
                ]);

                $data1 = $this->service->updateAccount(fun::denval($id, true), [
                    'roles'         => $request->roles
                ]);

                if($data2 > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'edit and update : data admin yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_anggota', ['sort'=>'name', 'by'=>'asc', 'search'=>'-', 'page'=>1]);
                }
                else {
                    return redirect()->route('admin_anggota_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_anggota_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Admin/Edit/Page => store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_anggota_edit', ['id' => $id])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
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
