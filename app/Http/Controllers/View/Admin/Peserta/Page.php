<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Peserta;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index($page) {
        return Inertia::render('admin/peserta/page', [
            'title'   => 'Daftar Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'page'    => $page
        ]);
    }
}
