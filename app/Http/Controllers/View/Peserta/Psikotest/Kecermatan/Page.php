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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\as0001_variabelsettingService;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;
use Exception;
use Meta;


class Page extends Controller {
    //
    protected as0001_variabelsettingService $variabelService;
    protected as1002_peserta_hasilnilai_teskecermatanService $peserta_hasilkecermatanService;
    protected as2001_kecermatan_kolompertanyaanService $kolompertanyaanService;
    protected as2002_kecermatan_soaljawabanService $kecermatansoalService;
    protected $titlepage, $path, $domain;
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
        $this->titlepage = 'Sedang Psikotest Kecermatan... | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $sesi): Inar|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);
        $isCache = 0;

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'none, nosnippet, noarchive, notranslate, noimageindex')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        if(Cache::has('page-psikotest_kecermatanasoaljawaban-allForTes-'.$sesi)) {
            $dataVariabel = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-dataVariabel'.$sesi);
            $dataKolomPertanyaan = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-dataKolomPertanyaan'.$sesi);
            $dataKecermatanSoal = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-dataKecermatanSoal'.$sesi);
            /*
            *Logicnya harus diubah dan improvisasi
            *Untuk sementara begini dulu
            *Logicnya cache dan database validasi apakah sama atau tidak
            *Jika tidak maka cache terupdate
            *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
            *
            if(json_encode($data) !== json_encode($database)) {
                Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id, $database, 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id);
            }
            */
        }
        else {
            $dataVariabel = $this->variabelService->get(1);
            $dataKolomPertanyaan = $this->kolompertanyaanService->allForTes($sesi);
            $dataKecermatanSoal = $this->kecermatansoalService->allForTes($sesi);
            Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-'.$sesi, 1, 12*3*60*60);
            Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-dataVariabel'.$sesi, $dataVariabel, 12*3*60*60);
            Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-dataKolomPertanyaan'.$sesi, $dataKolomPertanyaan, 12*3*60*60);
            Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-dataKecermatanSoal'.$sesi, $dataKecermatanSoal, 12*3*60*60);
        }

        return Inertia::render('peserta/psikotest/kecermatan/page', [
            'title'               => $this->titlepage,
            'token'               => csrf_token(),
            'unique'              => $unique,
            'variabel'            => $dataVariabel[0]['values'],
            'dataKolomPertanyaan' => $dataKolomPertanyaan,
            'dataKecermatanSoal'  => $dataKecermatanSoal,
            'sessionID'           => $sesi,
            'path'                => $this->path,
            'domain'              => $this->domain,
        ]);
    }

    public function bladeView(Request $request, int $sesi): View|Response|JsonResponse|Collection|array|String|int|null {
        $dataVariabel = $this->variabelService->get(1);
        $dataKolomPertanyaan = $this->kolompertanyaanService->allForTes($sesi);
        $dataKecermatanSoal = $this->kecermatansoalService->allForTes($sesi);
        return view('pages.peserta.psikotest.kecermatan.page', [
            'title'                => $this->titlepage,
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
