<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin\Admin\Myprofil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $this->titlepage = 'Profilku'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : melihat data profilku',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/admin/detil/page', [
            'title'    => $this->titlepage,
            'token'    => csrf_token(),
            'unique'   => $this->unique,
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

    public function bladeView(Request $request, $email): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->detail('email', $email);
        if($data['user'][0]['foto']) {
            $foto = asset('foto_user_admin/'.$data['user'][0]['foto']);
            $alt_foto = $data['user'][0]['name'];
        }
        else {
            $foto = asset('foto_user_admin/default_user_admin.png');
            $alt_foto = 'tidak ada foto';
        }
        $afoto = ['foto' => $foto, 'alt_foto' => $alt_foto];
        return view('pages.admin.admin.detil.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Profilku',
            'pathURL'              => url()->current(),
            'robots'               => $this->robots,
            'onetime'              => false,
            'breadcrumb'           => '/profilku',
            'navval'               => 'nav-profilku',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'isprofil'             => true,
            'data'                 => $data,
            'foto'                 => $afoto,
            'link_back'            => route('admin_dashboard'),
        ]);
    }

    public function updateFoto(Request $request, $type, $id): Response|JsonResponse|String|int|null {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Unauthorized!');
            }
            $credentials = $request->validate([
                'unique'    => 'required',
                'file_foto' => 'required',
            ]);
            if($credentials) {
                $data = $this->service->get(fun::denval($id, true));
                $newFileName = $data[0]['id'].'.'.$data[0]['email'].'.'.$request->file('file_foto')->extension();
                $foto = $request->file('file_foto')->storeAs(
                    '',
                    $newFileName,
                    'foto_user_admin'
                );
                $res = $this->service->updateFoto(fun::denval($id, true), [
                    'foto' => $foto,
                ]);
                if($res > 0) {
                    $this->activity->store([
                        'id_user'    => fun::denval($id, true),
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'edit and update : data admin yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    if($type == 'php') return redirect()->route('admin_myprofil', ['email' => $this->email]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Password Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return 1;
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Invalid Credentials!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateFoto!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }

    public function updatePassword(Request $request, $id) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Unauthorized!');
            }
            $credentials = $request->validate([
                'unique'   => 'required',
                'password' => 'required',
            ]);
            if($credentials) {
                $res = $this->service->updatePassword($id, fun::escape($request->password));
                if($res > 0) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'edit and update : password baru pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    if($request['type'] == 'php') return redirect()->route('admin_myprofil', ['email' => $this->email]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Password Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Invalid Credentials!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Admin/Myprofil/Page => updatePassword!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }

    public function updateRememberToken(Request $request, $roles, $type) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Unauthorized!');
            }
            if($this->roles == $roles) {
                $res = $this->service->updateRememberToken($this->id);
                if(($res != '') || ($res != null) || !is_null($res)) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'update : remember token baru pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    if($type == 'php') return redirect()->route('admin_logout');
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Password Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Invalide Credentials!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Admin/Myprofil/Page => updateRememberToken!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }

    public function updatePAT(Request $request, $roles, $type) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Unauthorized!');
            }
            if($this->roles == $roles) {
                $res = $this->service->updatePAT($this->id);
                if(($res != '') || ($res != null) || !is_null($res)) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'update : Personal Access Token pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    if($type == 'php') return redirect()->route('admin_logout');
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'PAT Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Invalid Credentials!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Admin/Myprofil/Page => updatePAT!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_myprofil', ['email' => $this->email])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }

    public function __destruct() {
        $this->activity  = null;
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
