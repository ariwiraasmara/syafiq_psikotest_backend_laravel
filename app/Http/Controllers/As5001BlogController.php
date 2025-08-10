<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\useractivitiesService;
use App\Services\as5001_blogService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;
class As5001BlogController extends Controller {
    //
    protected as5001_blogService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        Request $request,
        as5001_blogService $service,
        branding $brand
    ) {
        $this->service = $service;
        $this->brand = $brand;

        // ?
        $this->titlepage = $this->brand->getTitlepage();
        $this->path      = env('SESSION_PATH', '/');
        $this->domain    = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique    = fun::random('combwisp', 50);
    }
    
    #GET
    #url = '/api/admin-blog/{sort}/{by}/{search}'
    public function all(Request $request, String $sort = null, String $by = null, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'title';
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
                'deskripsi'  => 'read : membaca semua data artikel blog | admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Artikel Blog | Admin',
                'data'      => $this->service->all($sort, $by, $search)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->all!', [
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
    #url = '/api/admin-blog/{id}'
    public function get(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca data artikel blog | admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Artikel Blog | Admin',
                'data'      => $this->service->get($id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->get!', [
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
    #url = '/api/blog/'
    public function publicAll(Request $request): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data artikel blog publik ',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Artikel Blog Publik.',
                'data'      => $this->service->publicAll()
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->publicAll!', [
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
    #url = '/api/blog/{recents}'
    public function publicRecent(Request $request, $recents): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data artikel blog terbaru publik.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Artikel Blog Terbaru Publik',
                'data'      => $this->service->publicRecent($recents)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->publicRecent!', [
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
    #url = '/api/blog/{field}/{search}'
    public function publicSearch(Request $request, $field, $search): Response|JsonResponse|String|int|null {
        try {
            if(($field == '') || is_null($field) || empty($field)) $data = $this->service->publicAll();
            else $data = $this->service->publicSearch($field, $search);

            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua pencarian data artikel blog publik.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Pencarian Data Artikel Blog Publik',
                'data'      => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->publicSearch!', [
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
    #url = '/api/blog-detil/{title}'
    public function publicDetail(Request $request, $title): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca data artikel blog publik.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Artikel Blog Publik',
                'data'      => $this->service->publicDetail($title)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->publicDetail!', [
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
    #url = '/api/admin-blog'
    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            if($request->status == 'public') {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'content'  => 'required',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            else {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            if($credentials) {
                $created_at = now();
                if($request->tgl_publikasi != null) $created_at = date('Y-m-d H:i:s', strtotime($request->tgl_publikasi));
                $data = $this->service->store([
                    'id_user'    => $request->session()->get('id'),
                    'title'      => fun::readable($request->title),
                    'category'   => fun::readable($request->category),
                    'status'     => fun::readable($request->status),
                    'content'    => fun::readable($request->content),
                    'created_at' => $created_at,
                ]);
                if($data > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'create and store : data blog baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success'   => 1,
                        'pesan'     => 'Berhasil Menyimpan Data Blog',
                        'data'      => $data
                    ], 'created');
                }
                else {
                    return jsr::print([
                        'error'  => 1,
                        'pesan'  => 'Gagal Menyimpan Data Blog',
                        'data'   => $data
                    ], 'bad request');
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->store!', [
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
    #url = '/api/admin-blog/{id}'
    public function update(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($request->status == 'public') {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'content'  => 'required',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            else {
                $credentials = $request->validate([
                    'unique'   => 'required',
                    'title'    => 'required|string|max:255',
                    'category' => 'required',
                    'status'   => 'required',
                    'submit'   => 'required',
                ]);
            }
            if($credentials) {
                $data = $this->service->update($id, [
                    'title'      => fun::readable($request->title),
                    'category'   => fun::readable($request->category),
                    'status'     => fun::readable($request->status),
                    'content'    => fun::readable($request->content),
                ]);
                if($data > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'edit and update : data blog yang sudah ada',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Blog',
                        'data'    => $data
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'   => 2,
                        'pesan'   => 'Gagal Memperbaharui Data Blog',
                        'data'    => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 1,
                    'pesan'  => 'Is Not Valid!',
                ], 'not acceptable');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->update!', [
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
    #url = '/api/admin-blog/{type}/{id}'
    public function delete(Request $request, $type, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $data = $this->service->get($id);
                if($type == 'softDelete') $res = $this->service->softDelete($id);
                else $res = $this->service->hardDelete($id);

                if($res > 0) {
                    $properties = collect([
                        'data' => $data,
                        'type' => 'soft delete',
                        'deleted_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => $request->method(),
                        'deskripsi'  => 'soft delete : menghapus data blog ('.$type.').',
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
                    'error' => 2,
                    'pesan' => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As5001BlogController->delete!', [
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
