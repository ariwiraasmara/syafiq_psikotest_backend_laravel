<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Services\as0001_variabelsettingService;
use App\Libraries\jsr;
use Illuminate\Support\Facades\Log;
use Exception;
class As0001VariabelsettingController extends Controller {
    //
    protected as0001_variabelsettingService $service;
    public function __construct(as0001_variabelsettingService $service) {
        $this->service = $service;
    }

    #GET
    public function all(): Response|JsonResponse|String|int|null {
        try {
            if(Cache::has('page-variabelsetting-all')) $data = Cache::get('page-variabelsetting-all');
            else {
                Cache::put('page-variabelsetting-all', $data = $this->service->all(), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
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
    public function get(int $id): Response|JsonResponse|String|int|null {
        try {
            if(Cache::has('page-variabelsetting-get-'.$id)) $data = Cache::get('page-variabelsetting-get-'.$id);
            else {
                Cache::put('page-variabelsetting-get-'.$id, $data = $this->service->get($id), 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
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
    public function store(Request $request): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->store([
                'variabel' => $request->variabel,
                'values'   => $request->values,
            ]);
            if($data > 0) return jsr::print([
                'success'   => 1,
                'pesan'     => 'Berhasil Menyimpan Data Setting Variabel',
                'data'      => $data
            ], 'created');
            return jsr::print([
                'error'  => 1,
                'pesan'  => 'Gagal Menyimpan Data Setting Variabel',
                'data'   => $data
            ], 'bad request');
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

    #PUT/POST
    public function update(Request $request, int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->update($id, [
                'variabel'      => $request->variabel,
                'values'        => $request->values,
            ]);
            if($data > 0) return jsr::print([
                'success' => 1,
                'pesan'   => 'Berhasil Memperbaharui Data Setting Variabel',
                'data'    => $data
            ], 'ok');
            return jsr::print([
                'error'   => 1,
                'pesan'   => 'Gagal Memperbaharui Data Setting Variabel',
                'data'    => $data
            ], 'bad request');
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

    #POST/DELETE
    public function delete(int $id): Response|JsonResponse|String|int|null {
        try {
            $data = $this->service->delete($id);
            if($data > 0) return jsr::print([
                'success' => 1,
                'pesan'   => 'Berhasil Menghapus Data Setting Variabel',
                'data'    => $data
            ], 'ok');
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
