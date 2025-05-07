<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Edit;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Services\as2002_kecermatan_soaljawabanService;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;

class Page extends Controller {
    //
    protected as2002_kecermatan_soaljawabanService $service;
    public function __construct(as2002_kecermatan_soaljawabanService $service) {
        $this->service = $service;
    }

    public function view(Request $request, $id1, $id2) {
        $data = $this->service->getOne(fun::denval($id2, true));
        return Inertia::render('admin/psikotest/kecermatan/detil/edit/page', [
            'title'   => 'Edit Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
            'unique'  => fun::random('combwisp', 50),
            'nama'    => $request->session()->get('nama'),
            'id1'     => $id1,
            'id2'     => $id2,
            'data'    => $data[0]['soal_jawaban']
        ]);
    }

    public function bladeView(Request $request, $id1, $id2): View|Response|JsonResponse|Collection|array|String|int|null {
        $data = $this->service->getOne(fun::denval($id2, true));
        // return $data[0]['soal_jawaban'];
        return view('pages.admin.psikotest.kecermatan.detil.edit.page', [
            'title'                => 'Edit Detil Psikotest Kecermatan | Admin | Psikotest Online App',
            'appbar_title'         => 'Edit Detil Psikotest Kecermatan',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/edit',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id1'                  => $id1,
            'id2'                  => $id2,
            'data'                 => $data[0]['soal_jawaban']
        ]);
    }

    public function update(Request $request, $id1, $id2) {
        try {
            // return $request;
            $credentials = $request->validate([
                'unique'  => 'required|string',
                'soalA'   => 'required|integer',
                'soalB'   => 'required|integer',
                'soalC'   => 'required|integer',
                'soalD'   => 'required|integer',
                'jawaban' => 'required|integer',
            ]);
            if($credentials) {
                $soaljawaban = [
                    'soal' => [[
                        $request->soalA,
                        $request->soalB,
                        $request->soalC,
                        $request->soalD
                    ]],
                    'jawaban' => $request->jawaban
                ];
                $data = $this->service->update(fun::denval($id1, true), fun::denval($id2, true), [
                    'soal_jawaban' => $soaljawaban,
                ]);
                if($data->isNotEmpty()) {
                    return redirect('/admin/psikotest/kecermatan/detil/'.$id1);
                }
                else {
                    return redirect('/admin/psikotest/kecermatan/detil-edit/'.$id1.'/'.$id2)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect('/admin/psikotest/kecermatan/detil-edit/'.$id1.'/'.$id2)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/psikotest/kecermatan/detil-edit/'.$id1.'/'.$id2)->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
