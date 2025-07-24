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
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;
class As2002KecermatanSoaljawabanController extends Controller {
    //
    protected as2002_kecermatan_soaljawabanService|null $service;
    protected useractivitiesService|null $activity;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        Request $request,
        as2002_kecermatan_soaljawabanService $service,
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
    public function json(int $id) {
        $data = $this->service->json($id);
        return $data;
    }

    #GET
    #url = '/api/psikotest/kecermatan/soaljawaban/{id}'
    public function allForTes(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            if(Cache::has('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id)) {
                $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id);
                /*
                *Logicnya harus diubah dan improvisasi
                *Untuk sementara begini dulu
                *Logicnya cache dan database validasi apakah sama atau tidak
                *Jika tidak maka cache terupdate
                *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
                */
                $database = $this->service->allForTes($id)->toJson();
                if(json_encode($data) !== json_encode($database)) {
                    Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id, $database, 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                    $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id);
                }
            }
            else {
                Cache::put('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id, $this->service->all($id), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allForTes-'.$id);
            }
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : data soal dan jawaban psikotes kecermatan ',
                'properties' => json_encode($request->all())
            ]);
            return $data;
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->allData!', [
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
    #url = '/api/kecermatan/soaljawaban/all/{id}'
    public function allRaw(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->all($id);
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : data pertanyaan, soal dan jawaban psikotes kecermatan '.$data['pertanyaan'][0]['kolom_x'],
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Semua Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan '.$data['pertanyaan'][0]['kolom_x'],
                'data'    => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->allRaw!', [
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
    #url = '/api/kecermatan/soaljawaban/{id}'
    public function allCooked(Request $request, String|int $kolom): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->get($kolom);
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : data pertanyaan, soal dan jawaban psikotes kecermatan '.$data['pertanyaan'][0]['kolom_x'],
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan : '.$data['pertanyaan'][0]['kolom_x'],
                'data'    => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->allCooked!', [
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
    #url = '/api/kecermatan/soaljawaban/{id}'
    public function store(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'soal_jawaban' => 'required',
            ]);
            if($credentials) {
                $data = $this->service->store($id, [
                    'id2001'        => $id,
                    'soal_jawaban'  => $request->soal_jawaban,
                ]);
                if($data->isNotEmpty()) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'create and store : data soal dan jawaban psikotes kecermatan '.$data['kolom_x'].' baru',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'    => $data['data']
                    ], 'created');
                }
                else {
                    return jsr::print([
                        'error'   => 1,
                        'pesan'   => 'Gagal Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Is Not Valid!',
                ], 'Invalid Credentials!');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->store!', [
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
    #url = '/api/kecermatan/soaljawaban/{id1}/{id2}'
    public function update(Request $request, int $id1, int $id2): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'soal_jawaban' => 'required',
            ]);
            if($credentials) {
                $data = $this->service->update($id1, $id2, [
                    'soal_jawaban' => $request->soal_jawaban,
                ]);
                if($data->isNotEmpty()) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : data soal dan jawaban psikotes kecermatan '.$data['kolom_x'].' yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'    => $data['data']
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'  => $data['data']
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->update!', [
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
    #url = '/api/kecermatan/soaljawaban/{id1}/{id2}'
    public function delete(Request $request, int $id1, int $id2): Response|JsonResponse|String|int|null {
        try {
            if($id1 && $id2) {
                $data = $this->service->delete($id1, $id2);
                if($data->isNotEmpty()) {
                    $properties = [
                        'data'       => $data,
                        'deleted_at' => date('Y-m-d H:i:s')
                    ];
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'delete : data soal dan jawaban psikotes kecermatan '.$data['kolom_x'],
                        'properties' => json_encode($properties)
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'    => $data['data']
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 1,
                        'pesan' => 'Gagal Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'  => $data['data']
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
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As2002KecermatanSoaljawabanController->delete!', [
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
