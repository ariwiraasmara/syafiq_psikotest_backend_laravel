<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as2002_kecermatan_soaljawabanService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as2002_kecermatan_soaljawabanService $service) {
        $this->service = $service;
        $this->titlepage = 'Detil Psikotest Kecermatan Baru | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $id) {
        $unique = fun::random('combwisp', 50);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'none, nosnippet, noarchive, notranslate, noimageindex')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/psikotest/kecermatan/detil/baru/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $unique,
            'nama'    => $request->session()->get('nama'),
            'email'   => $request->session()->get('email'),
            'pat'     => $request->session()->get('pat'),
            'rtk'     => $request->session()->get('rtk'),
            'id'      => $id
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.psikotest.kecermatan.detil.baru.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Detil Psikotest Kecermatan Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/baru',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id
        ]);
    }

    public function store(Request $request, $id) {
        try {
            $credentials = $request->validate([
                'unique'  => 'required|string',
                'soalA'   => 'required|integer',
                'soalB'   => 'required|integer',
                'soalC'   => 'required|integer',
                'soalD'   => 'required|integer',
                'jawaban' => 'required|integer',
            ]);
            if($credentials) {
                $soal_jawaban = [
                    'soal'=> [[
                        intval($request->soalA),
                        intval($request->soalB),
                        intval($request->soalC),
                        intval($request->soalD)
                    ]],
                    'jawaban'=> intval($request->jawaban)
                ];
                $id2001 = fun::denval($id, true);
                $data = $this->service->store($id2001, [
                    'id2001'       => $id2001,
                    'soal_jawaban' => $soal_jawaban,
                ]);
                if($data->isNotEmpty()) {
                    return redirect('/admin/psikotest/kecermatan/detil/'.$id);
                }
                else {
                    return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
