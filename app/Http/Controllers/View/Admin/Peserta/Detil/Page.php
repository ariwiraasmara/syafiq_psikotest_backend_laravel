<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Peserta\Detil;
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
use App\Services\as1001_peserta_profilService;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as1001_peserta_profilService|null $service1;
    protected as1002_peserta_hasilnilai_teskecermatanService|null $service2;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as1001_peserta_profilService $service1,
        as1002_peserta_hasilnilai_teskecermatanService $service2,
        useractivitiesService $activity
    ) {
        // ?
        $this->service1 = $service1;
        $this->service2 = $service2;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Detil Peserta | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : melihat data peserta detil.',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, String $tgl1, String $tgl2, String $id): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service2->search($id, true, $tgl1, $tgl2);
        $unique = fun::random('combwisp', 50);

        if($tgl1 == 'null' || $tgl1 == '-' || $tgl1 == '' || $tgl1 == ' ' || $tgl1 == null) $tgl1 = '';
        if($tgl2 == 'null' || $tgl2 == '-' || $tgl2 == '' || $tgl2 == ' ' || $tgl2 == null) $tgl2 = '';

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/peserta/detil/page', [
            'title'      => $this->titlepage,
            'token'      => csrf_token(),
            'unique'     => $this->unique,
            'id'         => $this->id,
            'nama'       => $this->nama,
            'email'      => $this->email,
            'roles'      => $this->roles,
            'pat'        => $this->pat,
            'rtk'        => $this->rtk,
            'path'       => $this->path,
            'domain'     => $this->domain,
            'id'         => $id,
            'dataprofil' => $data['peserta'][0],
            'hasiltes'   => $data['hasiltes'],
            'tgl1'       => $tgl1,
            'tgl2'       => $tgl2
        ]);
    }

    public function bladeView(Request $request, String $tgl1, String $tgl2, String $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service2->search(fun::denval($id, true), $tgl1, $tgl2);

        if($tgl1 == 'null' || $tgl1 == '-' || $tgl1 == '' || $tgl1 == ' ' || $tgl1 == null) $tgl1 = '';
        if($tgl2 == 'null' || $tgl2 == '-' || $tgl2 == '' || $tgl2 == ' ' || $tgl2 == null) $tgl2 = '';

        // return $data['hasiltes'];
        return view('pages.admin.peserta.detil.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Detil Peserta',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/peserta-detil',
            'navval'               => 'nav-admin-peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => '',
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'id'                   => $id,
            'dataprofil'           => $data['peserta'][0],
            'hasiltes'             => $data['hasiltes'],
            'tgl1'                 => $tgl1,
            'tgl2'                 => $tgl2
        ]);
    }

    public function __destruct() {
        $this->service1  = null;
        $this->service2  = null;
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
