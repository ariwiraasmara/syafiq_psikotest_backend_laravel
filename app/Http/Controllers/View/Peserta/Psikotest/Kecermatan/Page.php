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
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;
use Exception;
use Illuminate\Support\Facades\Log;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $variabelService;
    protected as1002_peserta_hasilnilai_teskecermatanService $peserta_hasilkecermatanService;
    protected as2001_kecermatan_kolompertanyaanService $kolompertanyaanService;
    protected as2002_kecermatan_soaljawabanService $kecermatansoalService;
    public function __construct(
        as0001_variabelsettingService $variabelService,
        as1002_peserta_hasilnilai_teskecermatanService $peserta_hasilkecermatanService,
        as2001_kecermatan_kolompertanyaanService $kolompertanyaanService,
        as2002_kecermatan_soaljawabanService $kecermatansoalService
    ) {
        $this->variabelService = $variabelService;
        $this->peserta_hasilkecermatanService = $peserta_hasilkecermatanService;
        $this->kolompertanyaanService = $kolompertanyaanService;
        $this->kecermatansoalService = $kecermatansoalService;
    }

    public function view(Request $request, int $sesi): Inar|JsonResponse|Collection|array|String|int|null {
        $dataVariabel = $this->variabelService->get(1);
        $dataKolomPertanyaan = $this->kolompertanyaanService->allForTes($sesi);
        $dataKecermatanSoal = $this->kecermatansoalService->allForTes($sesi);
        return Inertia::render('peserta/psikotest/kecermatan/page', [
            'title'               => 'Sedang Psikotest Kecermatan... | Psikotest Online App',
            'pathURL'             => url()->current(),
            'robots'              => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'             => false,
            'unique'              => fun::random('combwisp', 50),
            'variabel'            => $dataVariabel[0]['values'],
            'dataKolomPertanyaan' => $dataKolomPertanyaan,
            'dataKecermatanSoal'  => $dataKecermatanSoal,
            'sessionID'           => $sesi,
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
    
    public function store(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique'                  => 'required',
                'hasilnilai_kolom_1'      => 'required|integer',
                'waktupengerjaan_kolom_1' => 'required|integer',
                'hasilnilai_kolom_2'      => 'required|integer',
                'waktupengerjaan_kolom_2' => 'required|integer',
                'hasilnilai_kolom_3'      => 'required|integer',
                'waktupengerjaan_kolom_3' => 'required|integer',
                'hasilnilai_kolom_4'      => 'required|integer',
                'waktupengerjaan_kolom_4' => 'required|integer',
                'hasilnilai_kolom_5'      => 'required|integer',
                'waktupengerjaan_kolom_5' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->peserta_hasilkecermatanService->store($id, [
                    'hasilnilai_kolom_1'      => $request->hasilnilai_kolom_1,
                    'waktupengerjaan_kolom_1' => $request->waktupengerjaan_kolom_1,
                    'hasilnilai_kolom_2'      => $request->hasilnilai_kolom_2,
                    'waktupengerjaan_kolom_2' => $request->waktupengerjaan_kolom_2,
                    'hasilnilai_kolom_3'      => $request->hasilnilai_kolom_3,
                    'waktupengerjaan_kolom_3' => $request->waktupengerjaan_kolom_3,
                    'hasilnilai_kolom_4'      => $request->hasilnilai_kolom_4,
                    'waktupengerjaan_kolom_4' => $request->waktupengerjaan_kolom_4,
                    'hasilnilai_kolom_5'      => $request->hasilnilai_kolom_5,
                    'waktupengerjaan_kolom_5' => $request->waktupengerjaan_kolom_5,
                ]);
                if($data > 0) {
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Hasil Nilai Peserta Tes!',
                        'data'    => $data
                    ], 'created');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menyimpan Data Hasil Nilai Peserta Tes!',
                        'data'  => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 1,
                    'pesan'  => 'Is Not Valid!',
                ], 'not acceptable');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->store!', [
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
}
