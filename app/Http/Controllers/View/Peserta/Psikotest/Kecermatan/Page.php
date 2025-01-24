<?php
// 
// 
// 
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\as0001_variabelsettingService;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Services\as2002_kecermatan_soalService;
class Page extends Controller {
    //
    protected as0001_variabelsettingService $variabelService;
    protected as2001_kecermatan_kolompertanyaanService $kolompertanyaanService;
    protected as2002_kecermatan_soalService $kecermatansoalService;
    public function __construct(
        as0001_variabelsettingService $variabelService,
        as2001_kecermatan_kolompertanyaanService $kolompertanyaanService,
        as2002_kecermatan_soalService $kecermatansoalService
    ) {
        $this->variabelService = $variabelService;
        $this->kolompertanyaanService = $kolompertanyaanService;
        $this->kecermatansoalService = $kecermatansoalService;
    }

    public function index() {
        $dataVariabel = $this->variabelService->get(1);
        return Inertia::render('peserta/psikotest/kecermatan/page', [
            'title'           => 'Sedang Psikotest Kecermatan... | Psikotest Online App',
            'pathURL'         => url()->current(),
            'robots'          => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'dataVariabel'    => $dataVariabel,
        ]);
    }
}
