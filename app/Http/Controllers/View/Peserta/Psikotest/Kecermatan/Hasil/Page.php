<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan\Hasil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\userdeviceloggingService;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Meta;

class Page extends Controller {
    //
    protected userdeviceloggingService $udl;
    protected as1002_peserta_hasilnilai_teskecermatanService|null $service;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $robots, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $headerLog, $activitiesLog;
    public function __construct(
        Request $request,
        as1002_peserta_hasilnilai_teskecermatanService $service,
        branding $brand
    ) {
        $this->service = $service;
        $this->brand = $brand;

        $this->titlepage = 'Hasil Psikotest Kecermatan Peserta'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate';

        if($request->session()->has('nama')) $this->nama = $request->session()->get('nama');
        else $this->nama = null;

        if($request->session()->has('email')) $this->email = $request->session()->get('email');
        else $this->email = null;

        if($request->session()->has('roles')) $this->roles = $request->session()->get('roles');
        else $this->roles = null;

        if($request->session()->has('fileUDH')) $this->filename = $request->session()->has('fileUDH');
        else $this->filename = date('Ymd');

        if($request->session()->has('id'))  {
            $this->id = $request->session()->get('id');
        }
        else {
            $this->id = 0;

            $this->headerLog = [
                'tanggal'       => date('Y-m-d H:i:s'),
                'host'          => $request->host(),
                'id_user'       => $this->id,
                'nama'          => $this->nama,
                'email'         => $this->email,
                'roles_user'    => $this->roles,
                'ip_address'    => $request->ip(),
            ];

            $this->activitiesLog = [
                'id_user'       => 0,
                'last_path'     => $request->path(),
                'last_url'      => $request->fullUrl(),
                'last_page'     => $this->titlepage,
                'method_page'   => 'Web - '.$request->method(),
                'deskripsi'     => 'read : halaman hasil psikotest kecermatan peserta.',
                'body_content'  => json_encode($request->all())
            ];

            $this->udl = new userdeviceloggingService(
                $this->id,
                $this->filename,
                $this->headerLog,
                $this->activitiesLog
            );
        }
    }

    public function reactView(Request $request, $no_identitas, $tgl_tes): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get($no_identitas, $tgl_tes);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        return Inertia::render('peserta/psikotest/kecermatan/hasil/page', [
            'title'        => $this->titlepage,
            'data'         => $data,
            'no_identitas' => $no_identitas,
            'tgl_tes'      => $tgl_tes,
        ]);
    }

    public function bladeView(Request $request, $no_identitas, $tgl_tes): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get($no_identitas, $tgl_tes);
        if($data['hasiltes']->count() > 0) {
            return view('pages.peserta.psikotest.kecermatan.hasil.page', [
                'title'                => $this->titlepage,
                'pathURL'              => url()->current(),
                'robots'               => $this->robots,
                'onetime'              => false,
                'breadcrumb'           => '/peserta/psikotest/kecermatan/hasil/'.$no_identitas.'/'.$tgl_tes,
                'is_breadcrumb_hidden' => 'hidden',
                'unique'               => $this->unique,
                'appbar_title'         => 'Hasil Psikotest Kecermatan',
                'data'                 => $data,
                'no_identitas'         => $no_identitas,
                'tgl_tes'              => $tgl_tes,
            ]);
        }
        else {
            return view('errors.404');
        }
    }

    public function __destruct() {
        $this->udl->print($this->activitiesLog);
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
