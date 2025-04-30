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
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected as1001_peserta_profilService $service1;
    protected as1002_peserta_hasilnilai_teskecermatanService $service2;
    public function __construct(
        as1001_peserta_profilService $service1,
        as1002_peserta_hasilnilai_teskecermatanService $service2
    ) {
        $this->service1 = $service1;
        $this->service2 = $service2;
    }

    public function view(Request $request, int $id): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service1->get($id);
        return Inertia::render('admin/peserta/detil/page', [
            'title'   => 'Detil Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'data'    => $data
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
