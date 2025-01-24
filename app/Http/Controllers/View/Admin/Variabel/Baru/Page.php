<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Variabel\Baru;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index() {
        return Inertia::render('admin/variabel/baru/page', [
            'title'   => 'Variabel Baru | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
        ]);
    }
}
