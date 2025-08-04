<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Baru;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as2002_kecermatan_soaljawabanService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as2002_kecermatan_soaljawabanService $service,
        useractivitiesService $activity
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Detil Psikotest Kecermatan Baru | Admin'.$this->brand->getTitlepage();
        $this->path = env('SESSION_PATH', '/');
        $this->domain = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique = fun::random('combwisp', 50);
        $this->robots = 'none, nosnippet, noarchive, notranslate, noimageindex';

        // ?
        $this->id = $request->session()->get('id');
        $this->nama = $request->session()->get('nama');
        $this->email = $request->session()->get('email');
        $this->roles = $request->session()->get('roles');
        $this->pat = $request->session()->get('pat');
        $this->rtk = $request->session()->get('rtk');
        $this->filename = $request->session()->get('fileUDH');

        $this->activity->store([
            'id_user'    => $this->id,
            'ip_address' => $request->ip(),
            'path'       => $request->path(),
            'url'        => $request->fullUrl(),
            'page'       => $this->titlepage,
            'event'      => 'Web - '.$request->method(),
            'deskripsi'  => 'read : sepertinya mau menambah data psikotes kecermatan detil baru?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $id) {
        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/psikotest/kecermatan/detil/baru/page', [
            'title'   => $this->titlepage,
            'token'   => csrf_token(),
            'unique'  => $this->unique,
            'id'      => $this->id,
            'nama'    => $this->nama,
            'email'   => $this->email,
            'roles'   => $this->roles,
            'pat'     => $this->pat,
            'rtk'     => $this->rtk,
            'path'    => $this->path,
            'domain'  => $this->domain,
            'id_data' => $id
        ]);
    }

    public function bladeView(Request $request, $id): View|Response|JsonResponse|Collection|array|String|int|null {
        return view('pages.admin.psikotest.kecermatan.detil.baru.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Detil Psikotest Kecermatan Baru',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/baru',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'id_data'              => $id
        ]);
    }

    public function store(Request $request, $id) {
        try {
            if (!Gate::allows('is-super-admin', Auth::user())) {
                return redirect()->route('admin_psikotest_kecermatan_detil')->with('error', 'Unauthorized!');
            }
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
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'Web - '.$request->method(),
                        'deskripsi'  => 'create and store : data psikotes kecermatan detil baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_psikotest_kecermatan_detil', ['id' => $id]);
                }
                else {
                    return redirect()->route('admin_psikotest_kecermatan_detil_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_psikotest_kecermatan_detil_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Psikotest/Kecermatan/Detil/Page => store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_psikotest_kecermatan_detil_baru')->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }

    public function __destruct() {
        $this->activity = null;
        $this->service   = null;
        $this->data      = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
        $this->robots    = null;
        $this->data      = null;
        $this->id        = null;
        $this->nama      = null;
        $this->email     = null;
        $this->roles     = null;
        $this->filename  = null;
    }
}
