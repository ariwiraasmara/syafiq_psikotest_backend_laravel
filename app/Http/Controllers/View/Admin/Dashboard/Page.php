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
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected userService $service;
    protected personalaccesstokensService $patService;
    protected as1001_peserta_profilService $pesertaService;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService
        ) {
            $this->service = $service;
            $this->patService = $patService;
            $this->pesertaService = $pesertaService;
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->pesertaService->allLatest();
        return Inertia::render('admin/dashboard/page', [
            'title'    => '',
            'pathURL'  => url()->current(),
            'robots'   => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'  => false,
            'data'     => $data,
            'req_nama' => $request->cookie('nama'),
        ]);
    }

    public function bladeView(Request $request): View|Response|JsonResponse|Collection|array|String|int|null {
        $token = $request->cookie('email');
        $data = $this->pesertaService->allLatest();
        return view('pages.admin.dashboard.page', [
            'title'                => 'Dashboard | Admin | Psikotest Online App',
            'appbar_title'         => 'Dashboard',
            'pathURL'              => url()->current(),
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'breadcrumb'           => '/admin/dashboard',
            'navval'               => 'nav-admin-dashboard',
            'is_breadcrumb_hidden' => 'hidden',
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'data'                 => $data,
            'token'                => $token
        ]);
    }
}
