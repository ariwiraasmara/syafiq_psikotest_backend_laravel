<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\useractivitiesService;
use App\Services\as0001_variabelsettingService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;
class As0001VariabelsettingController extends Controller {
    //
    protected as0001_variabelsettingService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        Request $request,
        as0001_variabelsettingService $service,
        branding $brand
    ) {
        // ?
        $this->service = $service;
        $this->brand = $brand;

        // ?
        $this->titlepage = $this->brand->getTitlepage();
        $this->path      = env('SESSION_PATH', '/');
        $this->domain    = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique    = fun::random('combwisp', 50);
    }

    #GET
    #url = '/api/variabel-setting/{sort}/{by}/{search}/'
    public function all(Request $request, String $sort = null, String $by = null, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
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
                'deskripsi'  => 'read : membaca semua data variabel setting.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Setting Variabel',
                'data'      => $this->service->all($sort, $by, $search)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->all!', [
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
    #url = '/api/variabel-setting/{id}'
    public function get(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca satu data variabel setting.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Setting Variabel',
                'data'      => $this->service->get($id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->get!', [
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

    #POST
    #url = '/api/variabel-setting/'
    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'variabel' => 'required|string|max:255',
                'values'   => 'required',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'variabel' => $request->variabel,
                    'values'   => fun::readable($request->values),
                ]);
                if($data > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'create and store : data variabel setting baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success'   => 1,
                        'pesan'     => 'Berhasil Menyimpan Data Setting Variabel',
                        'data'      => $data
                    ], 'created');
                }
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Gagal Menyimpan Data Setting Variabel',
                    'data'   => $data
                ], 'bad request');
            }
            else {
                return jsr::print([
                    'error'=> -13,
                    'pesan' => 'Invalid Credentials!'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->store!', [
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

    #PUT
    #url = '/api/variabel-setting/{id}'
    public function update(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'variabel' => 'required|string|max:255',
                'values'   => 'required',
            ]);
            if($credentials) {
                $data = $this->service->update($id, [
                    'variabel' => $request->variabel,
                    'values'   => fun::readable($request->values),
                ]);
                if($data > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : data variabel setting yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Setting Variabel',
                        'data'    => $data
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'   => 1,
                        'pesan'   => 'Gagal Memperbaharui Data Setting Variabel',
                        'data'    => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials!',
                ], 'not acceptable');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->update!', [
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
    #url = '/api/variabel-setting/{id}'
    public function delete(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $data = $this->service->get($id);
                $res = $this->service->delete($id);
                if($res > 0) {
                    $properties = collect([
                        'data'       => $data,
                        'deteled_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'delete : data variabel setting.',
                        'properties' => json_encode($properties)
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Setting Variabel',
                        'data'    => $res
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menghapus Data Setting Variabel',
                        'data'  => $res
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error' => 2,
                    'pesan' => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As0001VariabelsettingController->delete!', [
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
        $this->service   = null;
        $this->activity  = null;
        $this->titlepage = null;
        $this->path      = null;
        $this->domain    = null;
        $this->unique    = null;
    }
}
