<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as2001_kecermatan_kolompertanyaanService $service) {
        $this->service = $service;
        $this->titlepage = 'Psikotest Kecermatan Baru | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request) {
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

        return Inertia::render('admin/psikotest/kecermatan/baru/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => fun::random('combwisp', 10),
            'nama'    => $request->session()->get('nama'),
            'email'   => $request->session()->get('email'),
            'pat'     => $request->session()->get('pat'),
            'rtk'     => $request->session()->get('rtk'),
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.psikotest.kecermatan.baru.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Psikotest Kecermatan Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/baru',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 10),
            'nama'                 => $request->session()->get('nama')
        ]);
    }

    public function store(Request $request, String $type) {
        try {
            $credentials = $request->validate([
                'unique'  => 'required',
                'kolom_x' => 'required|string',
                'nilai_A' => 'required|integer',
                'nilai_B' => 'required|integer',
                'nilai_C' => 'required|integer',
                'nilai_D' => 'required|integer',
                'nilai_E' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'kolom_x' => fun::readable($request->kolom_x),
                    'nilai_A' => $request->nilai_A,
                    'nilai_B' => $request->nilai_B,
                    'nilai_C' => $request->nilai_C,
                    'nilai_D' => $request->nilai_D,
                    'nilai_E' => $request->nilai_E,
                ]);
                if($data > 0) {
                    return redirect('/admin/psikotest/kecermatan');
                }
                else {
                    return redirect('/admin/psikotest/kecermatan/baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect('/admin/psikotest/kecermatan/baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/psikotest/kecermatan/baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
