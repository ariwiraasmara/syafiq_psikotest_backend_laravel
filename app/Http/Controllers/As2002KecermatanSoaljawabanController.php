<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
class As2002KecermatanSoaljawabanController extends Controller {
    //
    protected as2002_kecermatan_soaljawabanService $service;
    public function __construct(as2002_kecermatan_soaljawabanService $service) {
        $this->service = $service;
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
            return $this->service->allForTes($id)->toJson();
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
            if(Cache::has('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id)) {
                $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id);
                /*
                *Logicnya harus diubah dan improvisasi
                *Untuk sementara begini dulu
                *Logicnya cache dan database validasi apakah sama atau tidak
                *Jika tidak maka cache terupdate
                *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
                */
                $database = $this->service->all($id);
                if(json_encode($data) !== json_encode($database)) {
                    Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id, $database, 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                    $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id);
                }
            }
            else {
                Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id, $this->service->all($id), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id);
            }
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Semua Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan '.$data['pertanyaan'][0]['kolom_x'],
                'data'    => $data,
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
            if(Cache::has('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom)) {
                $data = Cache::get('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom);
                /*
                *Logicnya harus diubah dan improvisasi
                *Untuk sementara begini dulu
                *Logicnya cache dan database validasi apakah sama atau tidak
                *Jika tidak maka cache terupdate
                *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
                */
                $database = $this->service->get($kolom);
                if(json_encode($data) !== json_encode($database)) {
                    Cache::put('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom, $database, 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                    $data = Cache::get('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom);
                }
            }
            else {
                Cache::put('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom, $this->service->get($kolom), 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
                $data = Cache::get('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom);
            }
    
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan : '.$data['pertanyaan'][0]['kolom_x'],
                'data'    => $data,
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
    public function store(Request $request, int $id): Response|JsonResponse|String|int|null {
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
                    Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id, $this->service->all($id), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'    => $data['data']
                    ], 'created');
                }
                return jsr::print([
                    'error'   => 1,
                    'pesan'   => 'Gagal Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
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
                    Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id1, $this->service->all($id1), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                        'data'    => $data['data']
                    ], 'ok');
                }
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                    'data'  => $data['data']
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
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
            $data = $this->service->delete($id1, $id2);
            if($data->isNotEmpty()) {
                Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id1, $this->service->all($id1), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                    'data'    => $data['data']
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'  => $data['data']
            ], 'bad request');
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
}
