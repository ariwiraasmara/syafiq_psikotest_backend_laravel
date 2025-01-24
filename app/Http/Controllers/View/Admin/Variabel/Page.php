<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Variabel;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\as0001_variabelsettingService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $service;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
    }

    public function index($page = 1) {
        if($page == 0 || $page < 0 || $page == '' || $page == ' ' || $page == null) $page = 1;
        return Inertia::render('admin/variabel/page', [
            'title'   => 'Variabel Setting | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'page'    => $page
        ]);
    }
}
