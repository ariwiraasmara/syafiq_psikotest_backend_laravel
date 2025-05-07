<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan\Hasil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Libraries\myfunction as fun;

class Page extends Controller {
    //
    protected as1002_peserta_hasilnilai_teskecermatanService $service;
    public function __construct(as1002_peserta_hasilnilai_teskecermatanService $service) {
        $this->service = $service;
    }

    public function view(Request $request, $no_identitas, $tgl_tes): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get($no_identitas, $tgl_tes);
        return Inertia::render('peserta/psikotest/kecermatan/hasil/page', [
            'title'        => 'Hasil Psikotest Kecermatan Peserta | Psikotest Online App',
            'pathURL'      => url()->current(),
            'robots'       => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'      => false,
            'data'         => $data,
            'no_identitas' => $no_identitas,
            'tgl_tes'      => $tgl_tes,
        ]);
    }

    public function bladeView(Request $request, $no_identitas, $tgl_tes): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get($no_identitas, $tgl_tes);
        // return $data;
        if($data['hasiltes']->count() > 0) {
            return view('pages.peserta.psikotest.kecermatan.hasil.page', [
                'title'                => 'Hasil Psikotest Kecermatan Peserta | Psikotest Online App',
                'pathURL'              => url()->current(),
                'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
                'onetime'              => false,
                'breadcrumb'           => '/peserta/psikotest/kecermatan/hasil/'.$no_identitas.'/'.$tgl_tes,
                'is_breadcrumb_hidden' => 'hidden',
                'unique'               => fun::random('combwisp', 50),
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
}
