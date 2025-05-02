<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Peserta;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Services\as1001_peserta_profilService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Libraries\myfunction as fun;

class Page extends Controller {
    //
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    public function view(Request $request, $page): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('admin/peserta/page', [
            'title'   => 'Daftar Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime' => false,
            'page'    => $page
        ]);
    }

    public function bladeView(Request $request, $sort, $by, $search): View|Response|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        
        $data = $this->service->allProfil($sort, $by, $search);
        $lastpage = 0;
        $fdata = null;
        if($data != null) {
            $fdata = $data['data'];
            $lastpage = $data['last_page'];
        }
        return view('pages.admin.peserta.page', [
            'title'                => 'Daftar Peserta | Admin | Psikotest Online App',
            'appbar_title'         => 'Daftar Peserta',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/peserta',
            'navval'               => 'nav-admin-peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'data'                 => $fdata,
            'sort'                 => $sort,
            'by'                   => $by,
            'search'               => $search,
            'lastpage'             => $lastpage,
        ]);
    }
}
