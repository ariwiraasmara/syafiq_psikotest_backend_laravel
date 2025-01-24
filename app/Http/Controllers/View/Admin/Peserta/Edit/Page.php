<?php
// 
// 
// 
namespace App\Http\Controllers\View\Admin\Peserta\Edit;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
   //
    public function index() {
        return Inertia::render('admin/peserta/edit/page', [
            'title'   => 'Edit Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
        ]);
    }
}
