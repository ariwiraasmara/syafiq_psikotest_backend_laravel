<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Peserta\Detil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\as1001_peserta_profilService;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as1001_peserta_profilService $service1;
    protected as1002_peserta_hasilnilai_teskecermatanService $service2;
    protected $titlepage, $path, $domain;
    public function __construct(
        as1001_peserta_profilService $service1,
        as1002_peserta_hasilnilai_teskecermatanService $service2
    ) {
        $this->service1 = $service1;
        $this->service2 = $service2;
        $this->titlepage = 'Detil Peserta | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
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
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/peserta/detil/page', [
            'title'      => 'Detil Peserta | Admin | Psikotest Online App',
            'token'      => csrf_token(),
            'unique'     => $unique,
            'nama'       => $request->session()->get('nama'),
            'email'      => $request->session()->get('email'),
            'pat'        => $request->session()->get('pat'),
            'rtk'        => $request->session()->get('rtk'),
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
            'title'                => 'Detil Peserta | Admin | Psikotest Online App',
            'appbar_title'         => 'Detil Peserta',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/peserta-detil',
            'navval'               => 'nav-admin-peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id,
            'dataprofil'           => $data['peserta'][0],
            'hasiltes'             => $data['hasiltes'],
            'tgl1'                 => $tgl1,
            'tgl2'                 => $tgl2
        ]);
    }
}
