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
use App\Services\as0001_variabelsettingService;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;
class As0001VariabelsettingController extends Controller {
    //
    protected as0001_variabelsettingService $service;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
    }

    #GET
    #url = '/api/variabel-setting/{sort}/{by}/{search}/'
    public function all(Request $request, String $sort = null, String $by = null, String $search = null): Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'variabel';
            if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
            if($search == 'null' || $search == '' || $search == ' ' || $search == null) $search = null;
            if(Cache::has('page-variabelsetting-all')) {
                $data = Cache::get('page-variabelsetting-all');
                /*
                *Logicnya harus diubah dan improvisasi
                *Untuk sementara begini dulu
                *Logicnya cache dan database validasi apakah sama atau tidak
                *Jika tidak maka cache terupdate
                *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
                */
                $database = $this->service->all($sort, $by, $search);
                if(json_encode($data) !== json_encode($database)) {
                    Cache::put('page-variabelsetting-all', $database, 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                    $data = Cache::get('page-variabelsetting-all');
                }
            }
            else {
                Cache::put('page-variabelsetting-all', $this->service->all($sort, $by, $search), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                $data = Cache::get('page-variabelsetting-all');
            }
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Setting Variabel',
                'data'      => $data
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
            if(Cache::has('page-variabelsetting-get-'.$id)) {
                $data = Cache::get('page-variabelsetting-get-'.$id);
                /*
                *Logicnya harus diubah dan improvisasi
                *Untuk sementara begini dulu
                *Logicnya cache dan database validasi apakah sama atau tidak
                *Jika tidak maka cache terupdate
                *Selain itu agar database tidak meload data lagi dan lagi supaya tidak menurunkan beban performa
                */
                $database = $this->service->get($id);
                if(json_encode($data) !== json_encode($database)) {
                    Cache::put('page-variabelsetting-get-'.$id, $database, 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                    $data = Cache::get('page-variabelsetting-get-'.$id);
                }
            }
            else {
                Cache::put('page-variabelsetting-get-'.$id, $this->service->get($id), 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
                $data = Cache::get('page-variabelsetting-get-'.$id);
            }
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Data Setting Variabel',
                'data'      => $data
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
                    Cache::put('page-variabelsetting-all', $this->service->all('variabel', 'asc', null), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
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
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Is Not Valid!'
            ]);
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
    public function update(Request $request, int $id): Response|JsonResponse|String|int|null {
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
                    Cache::put('page-variabelsetting-get-'.$id, $this->service->get($id), 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Memperbaharui Data Setting Variabel',
                        'data'    => $data
                    ], 'ok');
                }
                return jsr::print([
                    'error'   => 2,
                    'pesan'   => 'Gagal Memperbaharui Data Setting Variabel',
                    'data'    => $data
                ], 'bad request');
            }
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Is Not Valid!',
            ], 'not acceptable');
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
    public function delete(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->delete($id);
            if($data > 0) {
                Cache::forget('page-variabelsetting-get-'.$id);
                Cache::put('page-variabelsetting-all', $this->service->all('variabel', 'asc', null), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
                return jsr::print([
                    'success' => 1,
                    'pesan'   => 'Berhasil Menghapus Data Setting Variabel',
                    'data'    => $data
                ], 'ok');
            }
            return jsr::print([
                'error' => 1,
                'pesan' => 'Gagal Menghapus Data Setting Variabel',
                'data'  => $data
            ], 'bad request');
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
}
