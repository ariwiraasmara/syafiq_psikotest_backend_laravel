<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Services\as0001_variabelsettingService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
        $this->titlepage = 'Variabel Setting | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $sort, $by, $search): Inar|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];
        $unique = fun::random('combwisp', 50);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
            
        return Inertia::render('admin/variabel/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $unique,
            'nama'    => $request->session()->get('nama'),
            'email'   => $request->session()->get('email'),
            'page'    => $page,
            'pat'     => $request->session()->get('pat'),
            'rtk'     => $request->session()->get('rtk'),
        ]);
    }

    public function bladeView(Request $request, $sort, $by, $search): View|Response|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];

        $data = $this->service->all($sort, $by, $search);
        $lastpage = 0;
        $fdata = null;
        if($data != null) {
            $fdata = $data['data'];
            $lastpage = $data['last_page'];
        }
        return view('pages.admin.variabel.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Variabel Setting',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'pat'                  => $request->session()->get('pat'),
            'rtk'                  => $request->session()->get('rtk'),
            'data'                 => $fdata,
            'sort'                 => $sort,
            'by'                   => $by,
            'search'               => $search,
            'lastpage'             => $lastpage,
            'key'                  => fun::encrypt('@12!', 0),
            'page'                 => $page
        ]);
    }

    public function delete(Request $request, $id) {
        try {
            $data = $this->service->delete(fun::denval($id, true));
            if($data > 0) {
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Setting Variabel',
                    'data'    => $data
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Setting Variabel',
                'data'  => $data
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }
}
