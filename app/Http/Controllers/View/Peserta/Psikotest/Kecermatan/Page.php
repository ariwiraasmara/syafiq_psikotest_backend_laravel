<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Services\as0001_variabelsettingService;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\myfunction as fun;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $variabelService;
    protected as2001_kecermatan_kolompertanyaanService $kolompertanyaanService;
    protected as2002_kecermatan_soaljawabanService $kecermatansoalService;
    public function __construct(
        as0001_variabelsettingService $variabelService,
        as2001_kecermatan_kolompertanyaanService $kolompertanyaanService,
        as2002_kecermatan_soaljawabanService $kecermatansoalService
    ) {
        $this->variabelService = $variabelService;
        $this->kolompertanyaanService = $kolompertanyaanService;
        $this->kecermatansoalService = $kecermatansoalService;
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        $dataVariabel = $this->variabelService->get(1);
        return Inertia::render('peserta/psikotest/kecermatan/page', [
            'title'           => 'Sedang Psikotest Kecermatan... | Psikotest Online App',
            'pathURL'         => url()->current(),
            'robots'          => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'dataVariabel'    => $dataVariabel,
        ]);
    }

    public function bladeView(Request $request, int $sesi): View|Response|JsonResponse|Collection|array|String|int|null {
        $dataVariabel = $this->variabelService->get(1);
        $dataKolomPertanyaan = $this->kolompertanyaanService->allForTes($sesi);
        $dataKecermatanSoal = $this->kecermatansoalService->allForTes($sesi);
        return view('pages.peserta.psikotest.kecermatan.page', [
            'title'                => 'Sedang Psikotest Kecermatan... | Psikotest Online App',
            'pathURL'              => url()->current(),
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'breadcrumb'           => '/peserta/psikotest/kecermatan',
            'is_breadcrumb_hidden' => 'hidden',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'variabel'             => $dataVariabel[0]['values'],
            'dataKolomPertanyaan'  => $dataKolomPertanyaan,
            'dataKecermatanSoal'   => $dataKecermatanSoal,
            'sessionID'            => $sesi,
        ]);
    }
}
