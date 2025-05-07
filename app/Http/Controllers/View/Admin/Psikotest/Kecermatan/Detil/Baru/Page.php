<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Baru;
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

    public function view(Request $request, $id) {
        return Inertia::render('admin/psikotest/kecermatan/detil/baru/page', [
            'title'   => 'Detil Psikotest Kecermatan Baru | Admin | Psikotest Online App',
            'pathURL' => url()->current(),
            'robots'  => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime' => false,
            'unique'  => fun::random('combwisp', 50),
            'nama'    => $request->session()->get('nama'),
            'id'      => $id
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.psikotest.kecermatan.detil.baru.page', [
            'title'                => 'Detil Psikotest Kecermatan Baru | Admin | Psikotest Online App',
            'appbar_title'         => 'Detil Psikotest Kecermatan Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/baru',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => 'none, nosnippet, noarchive, notranslate, noimageindex',
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'nama'                 => $request->session()->get('nama'),
            'id'                   => $id
        ]);
    }

    public function store(Request $request, $id) {
        try {
            $credentials = $request->validate([
                'unique'  => 'required|string',
                'soalA'   => 'required|integer',
                'soalB'   => 'required|integer',
                'soalC'   => 'required|integer',
                'soalD'   => 'required|integer',
                'jawaban' => 'required|integer',
            ]);
            if($credentials) {
                $soal_jawaban = [
                    'soal'=> [[
                        intval($request->soalA),
                        intval($request->soalB),
                        intval($request->soalC),
                        intval($request->soalD)
                    ]],
                    'jawaban'=> intval($request->jawaban)
                ];
                $id2001 = fun::denval($id, true);
                $data = $this->service->store($id2001, [
                    'id2001'       => $id2001,
                    'soal_jawaban' => $soal_jawaban,
                ]);
                if($data->isNotEmpty()) {
                    return redirect('/admin/psikotest/kecermatan/detil/'.$id);
                }
                else {
                    return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect('/admin/psikotest/kecermatan/detil-baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
