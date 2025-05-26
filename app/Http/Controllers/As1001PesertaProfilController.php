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
use App\Services\as1001_peserta_profilService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
class As1001PesertaProfilController extends Controller {
    //
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    #GET
    #url = '/api/peserta/{sort}/{by}/{search}'
    public function all(Request $request, String $sort, String $by, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null) $search = null;

            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Peserta Tes!',
                'data'      => $this->service->allProfil($sort, $by, $search)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->all!', [
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
    #url '/api/peserta/{id}'
    public function get(Request $request, string $id): Response|JsonResponse|String|int|null {
        try {
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Detil Peserta',
                'data'      => $this->service->get($id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->get!', [
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
    #url = '#url '/api/peserta'
    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'nama'         => 'required|string',
                'no_identitas' => 'required|string',
                'email'        => 'required|string',
                'tgl_lahir'    => 'required|string',
                'asal'         => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'nama'          => fun::readable($request->nama),
                    'no_identitas'  => fun::readable($request->no_identitas),
                    'email'         => fun::readable($request->email),
                    'tgl_lahir'     => fun::readable($request->tgl_lahir),
                    'asal'          => fun::readable($request->asal),
                ]);
                if($data > 0) {
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menyimpan Data Peserta Tes!',
                        // $data
                    ], 'created');
                }
                return jsr::print([
                    'error' => 2,
                    'pesan' => 'Gagal Memperbaharui Data Peserta Tes!',
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->store!', [
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
    #url '/api/peserta/{id}'
    public function update(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'id'            => 'required|int',
                'email'         => 'required|string',
                'tgl_lahir'     => 'required|string',
                'asal'          => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->update($id, [
                    'email'         => fun::readable($request->email),
                    'tgl_lahir'     => fun::readable($request->tgl_lahir),
                    'asal'          => fun::readable($request->asal),
                ]);
                if($data > 0) {
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Peserta Tes!',
                        // 'data'    => $data
                    ], 'ok');
                }
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Gagal Memperbaharui Data Peserta Tes!',
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->update!', [
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
    #url = '/api/peserta/setup/'
    public function setUpPesertaTes(Request $request) {
        try {
            $data = $this->service->setUpPesertaTes([
                'nama'         => fun::readable($request->nama),
                'no_identitas' => fun::readable($request->no_identitas),
                'email'        => fun::readable($request->email),
                'tgl_lahir'    => fun::readable($request->tgl_lahir),
                'asal'         => fun::readable($request->asal),
                'tgl_tes'      => fun::readable($request->tgl_tes),
            ]);
            return $data;
            if($data['success'] == 1) {
                $data->put('success', 1);
                $data->put('pesan', 'Berhasil Setup Data Peserta Tes!');
                return $data->toJSON();
            }
            else if($data['success'] == 'datex') {
                $data->put('pesan', 'Anda sudah mengambil tes hari ini! Cobalah Esok hari lagi!');
                return $data->toJSON();
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Setup Data Peserta Tes!',
                'data'  => $data
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->setUpPesertaTes!', [
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
    #url '/api/peserta/{id}'
    public function delete(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->delete($id);
            if($data > 0) {
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Peserta Tes!',
                    'data'    => $data
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Peserta Tes!',
                'data'  => $data
            ], 'bad request');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada As1001PesertaProfilController->delete!', [
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
