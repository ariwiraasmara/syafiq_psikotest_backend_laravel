<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Peserta;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\as1001_peserta_profilService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;
use Exception;

class Page extends Controller {
    //
    protected as1001_peserta_profilService $service;
    protected $path, $domain = null;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('peserta/page', [
            'title'   => 'Formulir Peserta | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => true,
            'unique'  => fun::random('combwisp', 50),
            'path'    => $this->path,
            'domain'  => $this->domain
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.peserta.page', [
            'title'                => 'Formulir Peserta | Psikotest Online App',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => true,
            'unique'               => fun::random('combwisp', 50),
            'path'                 => $this->path,
            'domain'               => $this->domain
        ]);
    }

    public function setUpPesertaTes(Request $request): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->setUpPesertaTes([
                'unique'       => $request->unique,
                'nama'         => fun::readable($request->nama),
                'no_identitas' => fun::readable($request->no_identitas),
                'email'        => fun::readable($request->email),
                'tgl_lahir'    => fun::readable($request->tgl_lahir),
                'asal'         => fun::readable($request->asal),
                'tgl_tes'      => fun::readable($request->tgl_tes),
            ]);
            if($data['success'] == 1) {
                $data->put('success', 1);
                $data->put('pesan', 'Berhasil Setup Data Peserta Tes!');
                return $data->toJSON();
            }
            else if($data['success'] == 'datex') {
                $data->put('pesan', 'Anda sudah mengambil tes hari ini! Cobalah Esok hari lagi!');
                return $data->toJSON();
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Setup Data Peserta Tes!',
                    'data'  => $data
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->setUpPesertaTes!', [
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
