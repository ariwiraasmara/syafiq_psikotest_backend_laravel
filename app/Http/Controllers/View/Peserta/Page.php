<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\userdeviceloggingService;
use App\Services\as1001_peserta_profilService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected userdeviceloggingService $udl;
    protected as1001_peserta_profilService|null $service;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $robots, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    public function __construct(
        Request $request,
        as1001_peserta_profilService $service,
        branding $brand
    ) {
        $this->service = $service;
        $this->brand = $brand;

        $this->titlepage = 'Formulir Peserta'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        if($request->session()->has('id')) $this->id = $request->session()->get('id');
        else $this->id = 0;

        if($request->session()->has('nama')) $this->nama = $request->session()->get('nama');
        else $this->nama = null;

        if($request->session()->has('email')) $this->email = $request->session()->get('email');
        else $this->email = null;

        if($request->session()->has('roles')) $this->roles = $request->session()->get('roles');
        else $this->roles = null;

        $this->udl = new userdeviceloggingService(
            $this->id, $this->filename,
            [
                'tanggal'       => date('Y-m-d H:i:s'),
                'host'          => $request->host(),
                'id_user'       => $this->id,
                'nama'          => $this->nama,
                'email'         => $this->email,
                'roles_user'    => $this->roles,
                'ip_address'    => $request->ip(),
            ],
            [
                'last_path'     => $request->path(),
                'last_url'      => $request->fullUrl(),
                'last_page'     => $this->titlepage,
                'method_page'   => $request->method(),
                'ngapain'       => 'read',
                'body_content'  => json_encode($request->all())
            ]
        );
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);
        
        return Inertia::render('peserta/page', [
            'title'  => $this->titlepage,
            'token'  => csrf_token(),
            'unique' => $this->unique,
            'path'   => $this->path,
            'domain' => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.peserta.page', [
            'title'                => $this->titlepage,
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => true,
            'unique'               => $this->unique,
            'path'                 => $this->path,
            'domain'               => $this->domain
        ]);
    }

    public function setUpPesertaTes(Request $request): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->setUpPesertaTes([
                'unique'       => $request->unique,
                'nama'         => fun::readable($request->nama),
                'no_identitas' => fun::readable($request->no_identitas),
                'email'        => fun::readable($request->email),
                'tgl_lahir'    => fun::readable($request->tgl_lahir),
                'asal'         => fun::readable($request->asal),
                'tgl_tes'      => fun::readable($request->tgl_tes),
            ]);
            if($data['success'] == 1) {
                $data->put('success', 1);
                $data->put('pesan', 'Berhasil Setup Data Peserta Tes!');
                return $data->toJSON();
            }
            else if($data['success'] == 'datex') {
                $data->put('pesan', 'Anda sudah mengambil tes hari ini! Cobalah Esok hari lagi!');
                return $data->toJSON();
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Setup Data Peserta Tes!',
                    'data'  => $data
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->setUpPesertaTes!', [
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
        $this->udl->print();
        $this->service = null;
        $this->titlepage = null;
        $this->path = null;
        $this->domain = null;
        $this->unique = null;
        $this->robots = null;
        $this->id = null;
        $this->nama = null;
        $this->email = null;
        $this->roles = null;
    }
}
