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
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;

class As1002PesertaHasilnilaiTesKecermatanController extends Controller {
    //
    protected as1002_peserta_hasilnilai_teskecermatanService $service;
    public function __construct(as1002_peserta_hasilnilai_teskecermatanService $service) {
        $this->service = $service;
    }

    #GET
    #url = '/api/peserta/hasil/psikotest/kecermatan/semua/{id}'
    public function all(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            // if(Cache::has('page-pesertahasilnilaipsikotestkecermatan-all-'.$id)) {
            //     $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
            //     /*
            //     *Logicnya harus diubah dan improvisasi
            //     *Untuk sementara begini dulu
            //     *Logicnya cache dan database validasi apakah sama atau tidak
            //     *Jika tidak maka cache terupdate
            //     *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
            //     */
            //     $database = $this->service->all($id);
            //     if(json_encode($data) !== json_encode($database)) {
            //         Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $database, 1*1*60*60); // 1 hari x 1 jam x 60 menit x 60 detik
            //         $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
            //     }
            // }
            // else {
            //     Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $this->service->all($id), 1*24*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            //     $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
            // }
            return jsr::print([
                'success'   => 1,
                'for'       => 1,
                'pesan'     => 'Semua Data Hasil Nilai Peserta Ujian!',
                'data'      => $this->service->all($id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->all!', [
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
    #url = '/api/peserta-hasil-tes/{id}/{tgl}'
    public function get(Request $request, int $id, String $tgl): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->get($id, $tgl);
            return jsr::print([
                'success' => 1,
                'for'     => 2,
                'pesan'   => 'Data Hasil Nilai Peserta '.$data['peserta'][0]['nama'],
                'data'    => $data
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->get!', [
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
     #url = '/api/peserta/hasil/psikotest/kecermatan/{id}/{tgl_1}/{tgl_2}'
     public function search(Request $request, int $id, String $tgl_1, String $tgl_2): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->search($id, $tgl_1, $tgl_2);
            return jsr::print([
                'success' => 1,
                'for'     => 3,
                'pesan'   => 'Pencarian Data Hasil Nilai Peserta '.$data['peserta'][0]['nama'],
                'data'    => $data['hasiltes']
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->get!', [
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
    #url = '/api/peserta-hasil-tes/{id}'
    public function store(Request $request, $id, $nid): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'hasilnilai_kolom_1'      => 'required|integer',
                'waktupengerjaan_kolom_1' => 'required|integer',
                'hasilnilai_kolom_2'      => 'required|integer',
                'waktupengerjaan_kolom_2' => 'required|integer',
                'hasilnilai_kolom_3'      => 'required|integer',
                'waktupengerjaan_kolom_3' => 'required|integer',
                'hasilnilai_kolom_4'      => 'required|integer',
                'waktupengerjaan_kolom_4' => 'required|integer',
                'hasilnilai_kolom_5'      => 'required|integer',
                'waktupengerjaan_kolom_5' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->store(fun::denval($id, true), [
                    'hasilnilai_kolom_1'      => $request->hasilnilai_kolom_1,
                    'waktupengerjaan_kolom_1' => $request->waktupengerjaan_kolom_1,
                    'hasilnilai_kolom_2'      => $request->hasilnilai_kolom_2,
                    'waktupengerjaan_kolom_2' => $request->waktupengerjaan_kolom_2,
                    'hasilnilai_kolom_3'      => $request->hasilnilai_kolom_3,
                    'waktupengerjaan_kolom_3' => $request->waktupengerjaan_kolom_3,
                    'hasilnilai_kolom_4'      => $request->hasilnilai_kolom_4,
                    'waktupengerjaan_kolom_4' => $request->waktupengerjaan_kolom_4,
                    'hasilnilai_kolom_5'      => $request->hasilnilai_kolom_5,
                    'waktupengerjaan_kolom_5' => $request->waktupengerjaan_kolom_5,
                ]);
                if($data > 0) {
                    // Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $this->service->all($id), 1*24*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                    return jsr::print([
                        'success'      => 1,
                        'pesan'        => 'Berhasil Menyimpan Data Hasil Nilai Peserta Tes!',
                        // 'data'         => $data,
                        'no_identitas' => fun::denval($nid, true),
                    ], 'created');
                }
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Menyimpan Data Hasil Nilai Peserta Tes!',
                    'data'  => $data
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->store!', [
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
    #url = '/api/peserta-hasil-tes/{id}'
    public function update(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'hasilnilai_kolom_1'      => 'required|integer',
                'waktupengerjaan_kolom_1' => 'required|integer',
                'hasilnilai_kolom_2'      => 'required|integer',
                'waktupengerjaan_kolom_2' => 'required|integer',
                'hasilnilai_kolom_3'      => 'required|integer',
                'waktupengerjaan_kolom_3' => 'required|integer',
                'hasilnilai_kolom_4'      => 'required|integer',
                'waktupengerjaan_kolom_4' => 'required|integer',
                'hasilnilai_kolom_5'      => 'required|integer',
                'waktupengerjaan_kolom_5' => 'required|integer',
            ]);
            if($credentials) {
                $data = $this->service->update($id, [
                    'hasilnilai_kolom_1'      => $request->hasilnilai_kolom_1,
                    'waktupengerjaan_kolom_1' => $request->waktupengerjaan_kolom_1,
                    'hasilnilai_kolom_2'      => $request->hasilnilai_kolom_2,
                    'waktupengerjaan_kolom_2' => $request->waktupengerjaan_kolom_2,
                    'hasilnilai_kolom_3'      => $request->hasilnilai_kolom_3,
                    'waktupengerjaan_kolom_3' => $request->waktupengerjaan_kolom_3,
                    'hasilnilai_kolom_4'      => $request->hasilnilai_kolom_4,
                    'waktupengerjaan_kolom_4' => $request->waktupengerjaan_kolom_4,
                    'hasilnilai_kolom_5'      => $request->hasilnilai_kolom_5,
                    'waktupengerjaan_kolom_5' => $request->waktupengerjaan_kolom_5,
                ]);
                if($data > 0) {
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Hasil Nilai Peserta Tes!',
                        'data'    => $data
                    ], 'ok');
                }
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Memperbaharui Data Hasil Nilai Peserta Tes!',
                    'data'  => $data
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->update!', [
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
    #url = '/api/peserta/hasil/psikotest/kecermatan/{id}'
    public function delete(int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->delete($id);
            if($data > 0) {
                // Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $this->service->all($id), 1*24*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                return jsr::print([
                    'success'   => 1,
                    'pesan'     => 'Berhasil Menghapus Data Hasil Nilai Peserta Tes!',
                    'data'   => $data
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Hasil Nilai Peserta Tes!',
                'data'  => $data
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1002PesertaHasilnilaiTesKecermatanController->delete!', [
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
