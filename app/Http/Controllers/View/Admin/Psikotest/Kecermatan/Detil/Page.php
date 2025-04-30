<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
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
    protected as2002_kecermatan_soaljawabanService $service;
    public function __construct(as2002_kecermatan_soaljawabanService $service) {
        $this->service = $service;
    }

    public function view(Request $request, $page): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('admin/psikotest/kecermatan/detil/page', [
            'title'   => 'Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'page'    => $page,
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $page = @$_GET['page'];
        $data = $this->service->all(fun::denval($id, true));
        $jawaban = [];
        $lastpage = 1;
        if(!empty($data['soaljawaban'])) {
            $jawaban = $data['soaljawaban']['data'];
            $lastpage = $data['soaljawaban']['last_page'];
        }
        // return $jawaban;
        return view('pages.admin.psikotest.kecermatan.detil.page', [
            'title'                => 'Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'appbar_title'         => 'Detil Psikotest Kecermatan',
            'pathURL'              => url()->current().'?page='.$page,
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/'.$id.'?page='.$page,
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id,
            'pertanyaan'           => $data['pertanyaan'][0],
            'jawaban'              => $jawaban,
            'lastpage'             => $lastpage
        ]);
    }

    public function delete(Request $request, $id1, $id2) {
        try {
            $data = $this->service->delete(fun::denval($id1, true), fun::denval($id2, true));
            if($data->isNotEmpty()) {
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                    'data'    => $data['data']
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'  => $data['data']
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->delete!', [
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
