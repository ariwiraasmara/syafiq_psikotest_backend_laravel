<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Services\as2001_kecermatan_kolompertanyaanService;
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
    protected as2001_kecermatan_kolompertanyaanService $service;
    public function __construct(as2001_kecermatan_kolompertanyaanService $service){
        $this->service = $service;
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->all();
        return Inertia::render('admin/psikotest/kecermatan/page', [
            'title'   => 'Daftar Psikotest | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'unique'  => fun::random('combwisp', 50),
            'nama'    => $request->session()->get('nama'),
            'data'    => $data
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->all();
        return view('pages.admin.psikotest.kecermatan.page', [
            'title'                => 'Daftar Psikotest Kecermatan | Admin | Psikotest Online App',
            'appbar_title'         => 'Daftar Psikotest Kecermatan',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'data'                 => $data
        ]);
    }

    public function delete(Request $request, $id) {
        try {
            $data = $this->service->delete(fun::denval($id, true));
            if($data > 0) {
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Soal Pertanyaan Kecermatan!',
                ], 'ok');
            }
            return jsr::print([
                'error'   => 1,
                'pesan'   => 'Gagal Menghapus Data Soal Pertanyaan Kecermatan!',
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->delete!', [
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
