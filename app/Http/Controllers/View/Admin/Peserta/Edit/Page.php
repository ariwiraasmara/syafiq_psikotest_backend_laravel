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
use App\Services\as1001_peserta_profilService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
   //
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    public function view(Request $request, $id): Inar|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return Inertia::view('admin/peserta/edit/page', [
            'title'   => 'Edit Peserta | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
            'unique'  => fun::random('combwisp', 50),
            'nama'    => $request->session()->get('nama'),
            'id'      => $id,
            'data'    => $data[0]
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->get(fun::denval($id, true));
        return view('pages.admin.peserta.edit.page', [
            'title'                => 'Edit Peserta | Admin | Psikotest Online App',
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
