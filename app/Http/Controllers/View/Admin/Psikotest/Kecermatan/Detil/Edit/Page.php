<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Edit;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index() {
        return Inertia::render('admin/psikotest/kecermatan/detil/edit/page', [
            'title'   => 'Edit Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
        ]);
    }
}
