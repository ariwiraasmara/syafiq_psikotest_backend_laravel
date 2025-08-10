<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Services;

use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as2001_kecermatan_kolompertanyaanService {

    protected as2001_kecermatan_kolompertanyaanRepository|null $repo;
    public function __construct(as2001_kecermatan_kolompertanyaanRepository $repo) {
        $this->repo = $repo;
    }

    public function all(): array|Collection|String|int|null {
        try {
            return $this->repo->all();
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function allForTes(int $id): array|Collection|String|int|null {
        try {
            return $this->repo->allForTes($id);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(String|int $val): array|Collection|String|int|null {
        try {
            return $this->repo->get($val);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->get!', [
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
                'kolom_x'    => $val['kolom_x'],
                'nilai_A'    => $val['nilai_A'],
                'nilai_B'    => $val['nilai_B'],
                'nilai_C'    => $val['nilai_C'],
                'nilai_D'    => $val['nilai_D'],
                'nilai_E'    => $val['nilai_E'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->store!', [
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
                'nilai_A'    => $val['nilai_A'],
                'nilai_B'    => $val['nilai_B'],
                'nilai_C'    => $val['nilai_C'],
                'nilai_D'    => $val['nilai_D'],
                'nilai_E'    => $val['nilai_E'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->update!', [
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
            Log::channel('error-services')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanService->delete!', [
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