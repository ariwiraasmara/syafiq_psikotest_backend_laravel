<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index() {
        return Inertia::render('admin/psikotest/kecermatan/page', [
            'title'   => 'Daftar Psikotest | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
        ]);
    }
}
