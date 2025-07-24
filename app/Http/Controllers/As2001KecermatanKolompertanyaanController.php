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
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;
class As2001KecermatanKolompertanyaanController extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        Request $request,
        as2001_kecermatan_kolompertanyaanService $service,
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
    #url = '/api/kecermatan-kolompertanyaan'
    public function all(Request $request): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data psikotest kecermatan.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Soal Psikotest Kecermatan!!!',
                'data'      => $this->service->all()
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->all!', [
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
    #url = '/api/psikotest/kecermatan/pertanyaan/{id}'
    public function allForTes(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data psikotes kecermatan untuk ujian',
                'properties' => json_encode($request->all())
            ]);
            return $this->service->allForTes($id)->toJson();
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->all!', [
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
    #url = '/api/kecermatan/pertanyaan/{val}'
    public function get(Request $request, String|int $val): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->get($val);
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca data pertanyaan kecermatan '.$data[0]['kolom_x'],
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Pertanyaan Psikotest Kecermatan '.$data[0]['kolom_x'],
                'data'      => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->get!', [
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
    #url = '/api/kecermatan/kolompertanyaan'
    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'kolom_x' => 'required|string',
                'nilai_A' => 'required|integer',
                'nilai_B' => 'required|integer',
                'nilai_C' => 'required|integer',
                'nilai_D' => 'required|integer',
                'nilai_E' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'kolom_x' => fun::readable($request->kolom_x),
                    'nilai_A' => $request->nilai_A,
                    'nilai_B' => $request->nilai_B,
                    'nilai_C' => $request->nilai_C,
                    'nilai_D' => $request->nilai_D,
                    'nilai_E' => $request->nilai_E,
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
                        'deskripsi'  => 'create and store : data pertanyaan kecermatan baru',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Pertanyaan Psikotest Kecermatan!',
                        'data'    => $data
                    ], 'created');
                }
                else {
                    return jsr::print([
                        'error'   => 1,
                        'pesan'   => 'Gagal Menyimpan Data Pertanyaan Psikotest Kecermatan!',
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 1,
                    'pesan'  => 'Invalid Crendentials!',
                ], 'not acceptable');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->store!', [
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
    #url = '/api/kecermatan/kolompertanyaan/{id}'
    public function update(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'nilai_A' => 'required|integer',
                'nilai_B' => 'required|integer',
                'nilai_C' => 'required|integer',
                'nilai_D' => 'required|integer',
                'nilai_E' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->update($id, [
                    'nilai_A' => $request->nilai_A,
                    'nilai_B' => $request->nilai_B,
                    'nilai_C' => $request->nilai_C,
                    'nilai_D' => $request->nilai_D,
                    'nilai_E' => $request->nilai_E,
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
                        'deskripsi'  => 'edit and update : data pertanyaan kecermatan yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Pertanyaan Psikotest Kecermatan!',
                        'data'    => $data
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'   => 1,
                        'pesan'   => 'Gagal Memperbaharui Data Pertanyaan Psikotest Kecermatan!',
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->update!', [
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
    #url = '/api/kecermatan/kolompertanyaan/{id}'
    public function delete(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $data = $this->service->delete($id);
                if($data > 0) {
                    $properties = [
                        'data' => $data,
                        'delted_at' => date('Y-m-d H:i:s')
                    ];
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'delete : data pertanyaan psikotes kecermatan ',
                        'properties' => json_encode($properties)
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Soal Pertanyaan Kecermatan!',
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'   => 1,
                        'pesan'   => 'Gagal Menghapus Data Soal Pertanyaan Kecermatan!',
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2001KecermatanKolompertanyaanController->delete!', [
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
