<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Dashboard;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use App\Services\userService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    protected as1001_peserta_profilService $pesertaService;
    protected $titlepage, $path, $domain;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService
        ) {
            $this->service = $service;
            $this->patService = $patService;
            $this->pesertaService = $pesertaService;
            $this->titlepage = 'Dashboard | Admin | Psikotest Online App';
            $this->path = env('SESSION_PATH', '/');
            $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->pesertaService->allLatest();
        $unique = fun::random('combwisp', 50);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/dashboard/page', [
            'title'    => $this->titlepage,
            'token'    => csrf_token(),
            'unique'   => $unique,
            'nama'     => $request->session()->get('nama'),
            'data'     => $data,
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->pesertaService->allLatest();
        return view('pages.admin.dashboard.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Dashboard',
            'pathURL'              => url()->current(),
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'breadcrumb'           => '/admin/dashboard',
            'navval'               => 'nav-admin-dashboard',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'data'                 => $data
        ]);
    }
}
