<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Variabel\Edit;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index() {
        return Inertia::render('admin/variabel/edit/page', [
            'title'   => 'Edit Variabel | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
        ]);
    }
}
