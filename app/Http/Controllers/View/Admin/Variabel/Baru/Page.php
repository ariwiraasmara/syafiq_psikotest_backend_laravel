<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Services\as0001_variabelsettingService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $service;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
    }

    public function view(Request $request): Inar|JsonResponse|Collection|array|String|int|null {
        return Inertia::render('admin/variabel/baru/page', [
            'title'   => 'Variabel Baru | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
        ]);
    }

    public function bladeView(): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.variabel.baru.page', [
            'title'                => 'Variabel Baru | Admin | Psikotest Online App',
            'appbar_title'         => 'Variabel Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel-baru',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
        ]);
    }

    public function store(Request $request) {
        try {
            $credentials = $request->validate([
                'unique'   => 'required',
                'variabel' => 'required|string|max:255',
                'values'   => 'required',
            ]);
            if($credentials) {
                if($request->unique != null || $request->unique !== 'none' || $request->unique != '' || !empty($request->unique) || !is_null($request->unique)) {
                    $data = $this->service->store([
                        'variabel' => fun::readable($request->variabel),
                        'values'   => fun::readable($request->values),
                    ]);
                    if($data > 0) {
                        return redirect('/admin/variabel-setting/variabel/asc/-?page=1');
                    }
                    else {
                        return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                    }
                }
                else {
                    return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/variabel-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
