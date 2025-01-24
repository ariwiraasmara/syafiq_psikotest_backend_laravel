<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Dashboard;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Services\userService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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

    public function index() {
        $data = $this->pesertaService->allLatest();
        return Inertia::render('admin/dashboard/page', [
            'title'   => 'Dashboard | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'data'    => $data
        ]);
    }
}
