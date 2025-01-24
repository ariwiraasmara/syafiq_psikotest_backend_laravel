<?php
// 
// 
// 
namespace App\Http\Controllers\View\Peserta\Psikotest\Kecermatan\Hasil;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Page extends Controller {
    //
    public function index($no_identitas, $tgl_tes) {
        return Inertia::render('peserta/psikotest/kecermatan/hasil/page', [
            'title'           => 'Hasil Psikotest Kecermatan Peserta | Psikotest Online App',
            'pathURL'         => url()->current(),
            'robots'          => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'         => false,
            'no_identitas'    => $no_identitas,
            'tgl_tes'         => $tgl_tes,
        ]);
    }
}
