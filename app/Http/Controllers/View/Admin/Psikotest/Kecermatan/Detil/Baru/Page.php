<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Baru;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index() {
        return Inertia::render('admin/psikotest/kecermatan/detil/baru/page', [
            'title'   => 'Detil Psikotest Kecermatan Baru | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
        ]);
    }
}
