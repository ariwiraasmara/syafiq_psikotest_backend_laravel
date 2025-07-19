<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers\View\Admin\Monitor\UserLogActivities\Detil;
use Inertia\Inertia;
use Inertia\Response as Inar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Services\useractivitiesService;
use App\Services\userService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
use Meta;

class Page extends Controller {
    //
    protected useractivitiesService|null $activity;
    protected userService|null $user;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique, $data;
    protected $id, $nama, $email, $roles, $pat, $rtk, $filename;
    protected $robots;

    public function __construct(
        Request $request,
        branding $brand,
        useractivitiesService $activity,
        userService $user
    ) {
        // ?
        $this->brand = $brand;
        $this->activity = $activity;
        $this->user = $user;
        
        // ?
        $this->titlepage = 'Monitor Detil User Activities'.$this->brand->getTitlepage();
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
            'deskripsi'  => 'read : melihat data monitor user activities detil.',
            'properties' => json_encode($request->all())
        ]);
    }

    public function reactView(Request $request, $type, $id, $sort, $by, $search): Inar|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'id';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];

        meta()->title($this->titlepage)
            ->set('og:title', $this->titlepage)
            ->set('canonical', url()->current())
            ->set('og:url', url()->current())
            ->set('robots', $this->robots)
            ->set('XSRF-TOKEN', csrf_token())
            ->set('__unique__', $this->unique);

        Cookie::queue('__unique__', $this->unique, 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');
        Cookie::queue('XSRF-TOKEN', csrf_token(), 1 * 24 * 60 * 60, $this->path, $this->domain, true, true, false, 'None');

        return Inertia::render('admin/monitor/userlogactivities/detil/page', [
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
            'page'    => $page,
        ]);
    }

    public function bladeView(Request $request, $type, $id, $sort, $by, $search): View|Response|JsonResponse|Collection|array|String|int|null {
        if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'id';
        if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
        if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';
        $page = @$_GET['page'];

        $lastpage = 0;
        $fdata = null;
        if($type == 'user') {
            $where = ['id_user' => $id];
            $data = $this->activity->get('user', $where, $sort, $by, $search);
            $user = $this->user->get($id);
        }
        else if($type == 'id') {
            $where = ['id' => $id];
            $data = $this->activity->get('id', $where, $sort, $by, $search);
        }

        if($data != null) {
            if($type == 'user') {
                $fdata = collect([
                    'user' => $user,
                    'data' => $data['data']
                ]);
                $lastpage = $data['last_page'];
            }
            else {
                $user = $this->user->get($data[0]['id_user']);
                $fdata = collect([
                    'user' => $user,
                    'data' => $data
                ]);
                $lastpage = 0;
            }
        }
        else {
            $fdata = collect([
                'user' => $user,
                'data' => null
            ]);
        }
        return view('pages.admin.monitor.userlogactivities.detil.page', [
            'title'                => $this->titlepage,
            'appbar_title'         => 'Monitor Detil User Activities',
            'pathURL'              => url()->current(),
            'breadcrumb'           => '/admin/monitor/userlogactivities/detil',
            'navval'               => 'nav-monitor-userlogactivities-detil',
            'is_breadcrumb_hidden' => 'hidden',
            'robots'               => $this->robots,
            'onetime'              => false,
            'unique'               => $this->unique,
            'id'                   => $this->id,
            'nama'                 => $this->nama,
            'email'                => $this->email,
            'roles'                => $this->roles,
            'type'                 => $type,
            'type_val'             => $id,
            'data'                 => $fdata,
            'sort'                 => $sort,
            'by'                   => $by,
            'search'               => $search,
            'lastpage'             => $lastpage,
            'key'                  => fun::encrypt('@12!', 0),
            'page'                 => $page,
        ]);
    }

    public function backup(Request $request, $id) {
        try {
            if($id) {
                $data = $this->activity->backupUser($id);
                if($data['success']) {
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'backup : mencadangkan data satu admin',
                        'properties' => json_encode($request->all())
                    ]);
                    return response()->download($data['filename']);
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Backup Data User Admin',
                        'data'  => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Monitor/UserLogActivities/Detil/Page => backup!', [
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

    public function delete(Request $request, $id) {
        try {
            if($id) {
                $data = $this->activity->get('user', ['id_user' => fun::denval($id, true)], 'id', 'asc', '-');
                $res = $this->activity->delete(fun::denval($id, true));
                if($res > 0) {
                    $properties = collect([
                        'data' => $data['data'],
                        'type' => 'hard delete',
                        'deleted_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $this->activity->store([
                        'id_user'    => $this->id,
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'hard delete : menghapus seluruh data satu user activities (hard).',
                        'properties' => $properties
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Blog',
                        'data'    => $res
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menghapus Data Blog',
                        'data'  => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada Admin/Monitor/UserLogActivities/Detil/Page => delete!', [
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

    public function __destruct() {
        $this->activity  = null;
        $this->user      = null;
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
