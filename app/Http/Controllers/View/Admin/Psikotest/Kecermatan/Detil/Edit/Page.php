<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\View\Admin\Psikotest\Kecermatan\Detil\Edit;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Services\useractivitiesService;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\branding;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService|null $service1;
    protected as2002_kecermatan_soaljawabanService|null $service2;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;
    public function __construct(
        Request $request,
        branding $brand,
        as2001_kecermatan_kolompertanyaanService $service1,
        as2002_kecermatan_soaljawabanService $service2,
        useractivitiesService $activity
    ) {
        // ?
        $this->service1 = $service1;
        $this->service2 = $service2;
        $this->brand = $brand;
        $this->activity = $activity;

        // ?
        $this->titlepage = 'Edit Detil Psikotest Kecermatan | Admin'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : sepertinya mau mengubah data psikotes kecermatan detil yang sudah ada?',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $id1, $id2) {
        $data1 = $this->service1->get($id1);
        $data2 = $this->service2->getOne($id2);
        // return $data2[0];

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/psikotest/kecermatan/detil/edit/page', [
            'title'  => $this->titlepage,
            'token'  => csrf_token(),
            'unique' => $this->unique,
            'id'     => $this->id,
            'nama'   => $this->nama,
            'email'  => $this->email,
            'roles'  => $this->roles,
            'pat'    => $this->pat,
            'rtk'    => $this->rtk,
            'path'   => $this->path,
            'domain' => $this->domain,
            'id1'    => $id1,
            'id2'    => $id2,
            'data1'  => $data1[0],
            'data2'  => $data2[0]['soal_jawaban']
        ]);
    }

    public function bladeView(Request $request, $id1, $id2): View|Response|JsonResponse|Collection|array|String|int|null {
        $data2 = $this->service2->getOne(fun::denval($id2, true));
        // return $data[0]['soal_jawaban'];
        return view('pages.admin.psikotest.kecermatan.detil.edit.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Edit Detil Psikotest Kecermatan',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/psikotest/kecermatan/detil/edit',
            'navval'               => 'nav-admin-psikotest',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => fun::random('combwisp', 50),
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'id1'                  => $id1,
            'id2'                  => $id2,
            'data'                 => $data2[0]['soal_jawaban']
        ]);
    }

    public function update(Request $request, $id1, $id2) {
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
                        intval(fun::escape($request->soalA)),
                        intval(fun::escape($request->soalB)),
                        intval(fun::escape($request->soalC)),
                        intval(fun::escape($request->soalD))
                    ]],
                    'jawaban'=> intval(fun::escape($request->jawaban))
                ];
                $data = $this->service2->update(fun::denval($id1, true), fun::denval($id2, true), [
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
                        'deskripsi'  => 'edit and update : data psikotes kecermatan detil yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return redirect()->route('admin_psikotest_kecermatan_detil', ['id' => $id1]);
                }
                else {
                    return redirect()->route('admin_psikotest_kecermatan_detil_edit', ['id' => $id1, 'id2' => $id2])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
                }
            }
            else {
                return redirect()->route('admin_psikotest_kecermatan_detil_edit', ['id' => $id1, 'id2' => $id2])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Psikotest/Kecermatan/Detil/Page => update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return redirect()->route('admin_psikotest_kecermatan_detil_edit', ['id' => $id1, 'id2' => $id2])->with('error', 'Terjadi kesalahan! Tidak dapat menyimpan data!');
        }
    }
}
