<?php 
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)

namespace App\Repositories;

use App\Models\as2001_kecermatan_kolompertanyaan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as2001_kecermatan_kolompertanyaanRepository {

    protected as2001_kecermatan_kolompertanyaan $model;
    public function __construct(as2001_kecermatan_kolompertanyaan $model) {
        $this->model = $model;
    }

    public function all(): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                return $this->model
                            ->orderBy('kolom_x', 'asc')
                            ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function get(String|int $val): array|Collection|String|int|null {
        try {
            if($this->model->where(['id' => $val])->first()) {
                return $this->model->where(['id' => $val])
                                    ->Orwhere(['kolom_x' => $val])
                                    ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function store(array $values): array|Collection|String|int|null {
        try {
            $res = $this->model->create($values);
            if($res->id > 0) return $res->id;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanRepository->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function update(int $id, array $values): array|Collection|String|int|null {
        try {
            $res = $this->model->where(['id' => $id])->update($values);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanRepository->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function delete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->model->where(['id' => $id])->delete();
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2001_kecermatan_kolompertanyaanRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }
}
?>