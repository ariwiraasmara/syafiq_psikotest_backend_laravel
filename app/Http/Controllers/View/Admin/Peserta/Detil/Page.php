<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Peserta\Detil;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
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
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    public function index(int $id) {
        $data = $this->service->get($id);
        return Inertia::render('admin/peserta/detil/page', [
            'title'   => 'Detil Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'data'    => $data
        ]);
    }
}
