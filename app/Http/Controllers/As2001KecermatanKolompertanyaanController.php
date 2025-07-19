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
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
class As2001KecermatanKolompertanyaanController extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService $service;
    public function __construct(as2001_kecermatan_kolompertanyaanService $service) {
        $this->service = $service;
    }

    #GET
    #url = '/api/kecermatan-kolompertanyaan'
    public function all(Request $request): Response|JsonResponse|String|int|null {
        try {
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
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Pertanyaan Psikotest Kecermatan!',
                        'data'    => $data
                    ], 'created');
                }
                return jsr::print([
                    'error'   => 1,
                    'pesan'   => 'Gagal Menyimpan Data Pertanyaan Psikotest Kecermatan!',
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
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
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Pertanyaan Psikotest Kecermatan!',
                        'data'    => $data
                    ], 'ok');
                }
                return jsr::print([
                    'error'   => 1,
                    'pesan'   => 'Gagal Memperbaharui Data Pertanyaan Psikotest Kecermatan!',
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
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
            $data = $this->service->delete($id);
            if($data > 0) {
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Soal Pertanyaan Kecermatan!',
                ], 'ok');
            }
            return jsr::print([
                'error'   => 1,
                'pesan'   => 'Gagal Menghapus Data Soal Pertanyaan Kecermatan!',
            ], 'bad request');
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
}
