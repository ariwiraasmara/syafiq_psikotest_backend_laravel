<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\as2002_kecermatan_soalService;
use App\Libraries\jsr;
use Illuminate\Support\Facades\Log;
use Exception;
class As2002KecermatanSoaljawabanController extends Controller {
    //
    protected as2002_kecermatan_soalService $service;
    public function __construct(as2002_kecermatan_soalService $service
    ) {
        $this->service = $service;
    }

    #GET
    public function json(int $id) {
        $data = $this->service->json($id);
        return $data;
    }

    #GET
    public function allRaw(int $id): Response|JsonResponse|String|int|null {
        try {
            if(Cache::has('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id)) $data = Cache::get('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id);
            else {
                Cache::put('page-psikotest_kecermatanasoaljawaban-allRaw-'.$id, $this->service->all($id), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
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
    public function allCooked(String|int $kolom): Response|JsonResponse|String|int|null {
        try {
            if(Cache::has('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom)) $data = Cache::get('page-psikotest_kecermatansoaljawaban-allCooked-'.$kolom);
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
    public function store(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->store($id, [
                'id2001'        => $id,
                'soal_jawaban'  => $request->soal_jawaban,
            ]);
    
            if($data->isNotEmpty()) return jsr::print([
                'success' => 1,
                'pesan'   => 'Berhasil Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'    => $data['data']
            ], 'created');
    
            return jsr::print([
                'error'   => 1,
                'pesan'   => 'Gagal Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
            ], 'bad request');
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

    #PUT/POST
    public function update(Request $request, int $id1, int $id2): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->update($id1, $id2, [
                'soal_jawaban' => $request->soal_jawaban,
            ]);
    
            if($data->isNotEmpty()) return jsr::print([
                'success' => 1,
                'pesan'   => 'Berhasil Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'    => $data['data']
            ], 'ok');
    
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'  => $data['data']
            ], 'bad request');
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

    #DELETE/POST
    public function delete(int $id1, int $id2): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->delete($id1, $id2);
            if($data->isNotEmpty()) return jsr::print([
                'success' => 1,
                'pesan'   => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'],
                'data'    => $data['data']
            ], 'ok');
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
