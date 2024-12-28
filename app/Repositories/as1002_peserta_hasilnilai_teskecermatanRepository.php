<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as1002_peserta_hasilnilai_teskecermatan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as1002_peserta_hasilnilai_teskecermatanRepository {

    protected as1002_peserta_hasilnilai_teskecermatan $model;
    public function __construct(as1002_peserta_hasilnilai_teskecermatan $model) {
        $this->model = $model;
    }

    public function all(array $where): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) return $this->model->where($where)->get();
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) return $this->model->where($where)->get();
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanRepository->store!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanRepository->update!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanRepository->delete!', [
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
