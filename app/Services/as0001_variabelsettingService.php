<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as0001_variabelsettingRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;
class as0001_variabelsettingService {

    protected as0001_variabelsettingRepository $repo;
    public function __construct(as0001_variabelsettingRepository $repo) {
        $this->repo = $repo;
    }

    public function all(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            $data = $this->repo->all($sort, $by, $search);
            return $data;
            // return $data->map(function ($item) {
            //     // return $item['id'] = fun::enval($item['id'], true);
            //     return $item['id'];
            // });
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as0001_variabelsettingService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(int $id): array|Collection|String|int|null {
        try {
            return $this->repo->get(['id' => $id]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as0001_variabelsettingService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function store(array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo->store([
                'variabel'      => $val['variabel'],
                'values'        => $val['values'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as0001_variabelsettingService->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function update(int $id, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo->update($id, [
                'variabel'      => $val['variabel'],
                'values'        => $val['values'],
                'updated_at'    => now(),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as0001_variabelsettingService->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function delete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo->delete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as0001_variabelsettingService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}