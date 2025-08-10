<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\userdevicehistoryRepository;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Browser;
use Exception;

class userdevicehistoryService {
    //
    protected userdevicehistoryRepository|null $repo;

    public function __construct(userdevicehistoryRepository $repo) {
        $this->repo = $repo;
    }

    public function all(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            return $this->repo->all($sort, $by, $search);
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

    // ! Fitur ini tidak ada
    // ! Namun tetap dibuat
    public function update(int $id, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo->update($id, [
                'ip_addess'  => $val['ip_addess'],
                'user_agent' => $val['user_agent'],
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

    public function __destruct() {
        $this->repo = null;
    }
}