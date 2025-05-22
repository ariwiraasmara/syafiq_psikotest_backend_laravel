<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Peserta\Edit;
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
use App\Services\as1001_peserta_profilService;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
   //
    protected as1001_peserta_profilService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
        $this->titlepage = 'Edit Peserta | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);
        $data = $this->service->get(fun::denval($id, true));

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'index, follow, snippet, max-snippet:99, max-image-preview:standard, noarchive, notranslate')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::view('admin/peserta/edit/page', [
            'title'   => $this->titlepage,
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'token'   => csrf_token(),
            'unique'  => $unique,
            'nama'    => $request->session()->get('nama'),
            'email'   => $request->session()->get('email'),
            'pat'     => $request->session()->get('pat'),
            'rtk'     => $request->session()->get('rtk'),
            'id'      => $id,
            'data'    => $data[0]
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return view('pages.admin.peserta.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Peserta',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/peserta-edit',
            'navval'               => 'nav-admin-peserta',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id,
            'data'                 => $data[0]
        ]);
    }

    public function update(Request $request, $id) {
        try {
            $credentials = $request->validate([
                'unique'    => 'required',
                'email'     => 'required|string',
                'tgl_lahir' => 'required|string',
                'asal'      => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->update(fun::denval($id, true), [
                    'email'         => fun::readable($request->email),
                    'tgl_lahir'     => fun::readable($request->tgl_lahir),
                    'asal'          => fun::readable($request->asal),
                ]);
                if($data > 0) {
                    return redirect('/admin/peserta-detil/-/-/'.$id);
                }
                else {
                    return redirect('/admin/peserta-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect('/admin/peserta-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/peserta-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
