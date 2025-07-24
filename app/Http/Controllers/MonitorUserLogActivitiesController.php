<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Services\useractivitiesService;
use App\Services\userService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;
use Meta;

class MonitorUserLogActivitiesController extends Controller {
    //
    protected userService|null $user;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        Request $request,
        userService $user,
        useractivitiesService $activity,
        branding $brand
    ) {
        // ?
        $this->user  = $user;
        $this->activity = $activity;
        $this->brand    = $brand;

        // ?
        $this->titlepage = $this->brand->getTitlepage();
        $this->path      = env('SESSION_PATH', '/');
        $this->domain    = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique    = fun::random('combwisp', 50);

        // ?
    }

    #GET
    #url = '/api/monitor/user-log-activities/{sort}/{by}/{search}'
    public function allUser(Request $request, String $sort = null, String $by = null, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'id_user';
            if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
            if($search == 'null' || $search == '' || $search == ' ' || $search == null) $search = null;

            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data user log activities | admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data User Log Activities | Admin',
                'data'      => $this->activity->all($sort, $by, $search)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->allUser!', [
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

    #GET
    #url = '/api/monitor/user-log-activities/{type}/{id}/{sort}/{by}/{search}'
    public function getUser(Request $request, $type, $id, String $sort = null, String $by = null, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'id';
            if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
            if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = '';

            if($type == 'user') {
                $where = ['id_user' => $id];
                $data = $this->activity->get('user', $where, $sort, $by, $search);
                $user = $this->user->get($id);
            }
            else if($type == 'id') {
                $where = ['id' => $id];
                $data = $this->activity->get('id', $where, $sort, $by, $search);
            }

            $fdata = null;
            if($data != null) {
                if($type == 'user') {
                    $fdata = collect([
                        'user' => $user,
                        'data' => $data['data']
                    ]);
                }
                else {
                    $user = $this->user->get($data[0]['id_user']);
                    $fdata = collect([
                        'user' => $user,
                        'data' => $data
                    ]);
                }
            }
            else {
                $fdata = collect([
                    'user' => $user,
                    'data' => null
                ]);
            }

            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : melihat data user activities detil | admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data User Log Activities Detil | Admin',
                'data'      => $fdata
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->getUser!', [
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

    #DELETE
    #url = '/api/monitor/user-log-activities-truncate-all'
    public function truncate(Request $request): Response|JsonResponse|String|int|null {
        try {
            $res = $this->activity->truncate();
            if($res > 0) {
                $token = msr::read($request->bearerToken());
                $this->activity->store([
                    'id_user'    => $token['id'],
                    'ip_address' => $request->ip(),
                    'path'       => $request->path(),
                    'url'        => $request->fullUrl(),
                    'page'       => $request->header()['titlepage'][0].$this->titlepage,
                    'event'      => 'API - '.$request->method(),
                    'deskripsi'  => 'read : melihat data user activities detil | admin.',
                    'properties' => json_encode($request->all())
                ]);
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Semua Data User Log Activities | Admin',
                ], 'ok');
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Menghapus Semua Data User Log Activities | Admin',
                ], 'ok');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->truncate!', [
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

    #DELETE
    #url = '/api/monitor/user-log-activities/{id}'
    public function deleteOneUserAdminActivities(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $data = $this->activity->get('id_user', $id, 'id', 'asc', '-');
                $res = $this->activity->delete($id);
                if($res > 0) {
                    $properties = [
                        'data'       => $data,
                        'deleted_at' => date('Y-m-d')
                    ];
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'read : melihat data user activities detil | admin.',
                        'properties' => json_encode($properties)
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data User Log Activities | Admin',
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menghapus Data User Log Activities | Admin',
                    ], 'ok');
                }
            }
            else {
                return jsr::print([
                    'error'=> 2,
                    'pesan' => 'Invalid Credentials!'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->deleteOneUserAdminActivities!', [
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

    #GET
    #url = '/api/monitor/user-log-activities-backup-all'
    public function backupAll(Request $request): Response|JsonResponse|String|int|null {
        try {
            $res = $this->activity->backupAll();
            if($res) {
                $token = msr::read($request->bearerToken());
                $this->activity->store([
                    'id_user'    => $token['id'],
                    'ip_address' => $request->ip(),
                    'path'       => $request->path(),
                    'url'        => $request->fullUrl(),
                    'page'       => $request->header()['titlepage'][0].$this->titlepage,
                    'event'      => 'API - '.$request->method(),
                    'deskripsi'  => 'backup : semua data user activities detil | admin.',
                    'properties' => json_encode($request->all())
                ]);
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Backup Semua Data User Log Activities | Admin',
                ], 'ok');
            }
            else {
                return jsr::print([
                    'error'=> 1,
                    'pesan' => 'Gagal Backup Semua Data User Log Activities! | Admin'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->backupAll!', [
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

    #GET
    #url = '/api/monitor/user-log-activities-backup/{id}'
    public function backupUser(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $res = $this->activity->backupUser($id);
                if($res) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'backup : satu data user activities | admin.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Backup Data User Log Activities | Admin',
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'=> 1,
                        'pesan' => 'Gagal Backup Data User Log Activities! | Admin'
                    ]);
                }
            }
            else {
                return jsr::print([
                    'error' => 2,
                    'pesan' => 'Invalid Credentials!'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada MonitorUserLogActivitiesController->backupUser!', [
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
        $this->user      = null;
        $this->activity  = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
    }
}
