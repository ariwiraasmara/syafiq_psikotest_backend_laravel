<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Edit;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService $service;
    protected $titlepage, $path, $domain;
    public function __construct(as2001_kecermatan_kolompertanyaanService $service) {
        $this->service = $service;
        $this->titlepage = 'Edit Psikotest Kecermatan | Admin | Psikotest Online App';
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
    }

    public function reactView(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        $unique = fun::random('combwisp', 50);
        $data = $this->service->get($id);

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', 'none, nosnippet, noarchive, notranslate, noimageindex')
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $unique);

        Cookie::queue('__unique__', $unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/psikotest/kecermatan/edit/page', [
            'title'   => $this->titlepage,
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
        return view('pages.admin.psikotest.kecermatan.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Psikotest Kecermatan',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/edit',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 10),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id,
            'data'                 => $data[0]
        ]);
    }

    public function update(Request $request, String $id) {
        try {
            $credentials = $request->validate([
                'unique'  => 'required',
                'nilai_A' => 'required|integer',
                'nilai_B' => 'required|integer',
                'nilai_C' => 'required|integer',
                'nilai_D' => 'required|integer',
                'nilai_E' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->update(fun::denval($id, true), [
                    'nilai_A' => $request->nilai_A,
                    'nilai_B' => $request->nilai_B,
                    'nilai_C' => $request->nilai_C,
                    'nilai_D' => $request->nilai_D,
                    'nilai_E' => $request->nilai_E,
                ]);
                if($data > 0) {
                    return redirect('/admin/psikotest/kecermatan');
                }
                else {
                    return 1;
                    return redirect('/admin/psikotest/kecermatan-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return 2;
                return redirect('/admin/psikotest/kecermatan-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return 3;
            return redirect('/admin/psikotest/kecermatan-edit/'.$id)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
