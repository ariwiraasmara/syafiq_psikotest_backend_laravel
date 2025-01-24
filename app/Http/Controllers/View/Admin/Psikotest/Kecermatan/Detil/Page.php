<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil;
use Inertia\Inertia;
use App\Services\as2002_kecermatan_soalService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    protected as2002_kecermatan_soalService $service;
    public function __construct(as2002_kecermatan_soalService $service) {
        $this->service = $service;
    }

    public function index($page) {
        return Inertia::render('admin/psikotest/kecermatan/detil/page', [
            'title'   => 'Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'page'    => $page,
        ]);
    }
}
