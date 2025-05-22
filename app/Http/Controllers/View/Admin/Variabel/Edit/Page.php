<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Variabel\Edit;
use Inertia\Inertia;
use Inertia\Response as Inar;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Services\as0001_variabelsettingService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as0001_variabelsettingService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
        $this->titlepage = 'Edit Variabel | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get($id);

        $unique = fun::random('combwisp', 50);
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'none, nosnippet, noarchive, notranslate, noimageindex')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        
        return Inertia::render('admin/variabel/edit/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $unique,
            'nama'    => $request->session()->get('nama'),
            'pat'     => $request->session()->get('pat'),
            'rtk'     => $request->session()->get('rtk'),
            'id'      => $id,
            'data'    => $data[0],
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return view('pages.admin.variabel.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Variabel',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/variabel-edit',
            'navval'               => 'nav-admin-variabel',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'id'                   => $id,
            'data'                 => $data,
            'nama'                 => $request->session()->get('nama'),
        ]);
    }

    public function update(Request $request, String $id, String $type) {
        try {
            $credentials = $request->validate([
                'unique'   => 'required',
                'variabel' => 'required|string|max:255',
                'values'   => 'required',
            ]);
            if($credentials) {
                $data = $this->service->update(fun::denval($id, true), [
                    'variabel' => fun::readable($request->variabel),
                    'values'   => fun::readable($request->values),
                ]);
                if($data > 0) {
                    if($type == 'php') return redirect('/admin/variabel-setting/variabel/asc/-?page=1');
                    else if($type == 'js') {
                        return new Response([
                            'success' => 1,
                            'pesan'   => 'Berhasil Menyimpan Data Setting Variabel',
                        ]);
                    }
                }
                else {
                    return redirect('/admin/variabel-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            return redirect('/admin/variabel-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/variabel-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
