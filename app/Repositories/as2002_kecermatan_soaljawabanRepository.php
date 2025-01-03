<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as2002_kecermatan_soaljawaban;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as2002_kecermatan_soaljawabanRepository {

    protected as2002_kecermatan_soaljawaban $model;
    public function __construct(as2002_kecermatan_soaljawaban $model) {
        $this->model = $model;
    }

    public function all(int $id): array|Collection|String|int|null {
        try {
            if($this->model->where(['id2001' => $id])->first()) {
                return $this->model->where(['id2001' => $id])
                                    ->orderBy('id', 'asc')
                                    ->paginate(10)
                                    ->toArray();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function all50(int $id): array|Collection|String|int|null {
        try {
            if($this->model->where(['id2001' => $id])->first()) {
                return $this->model->where(['id2001' => $id])
                                    ->orderBy('id', 'asc')
                                    ->limit(50)
                                    ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->all50!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function allData(): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                return $this->model->orderBy('id', 'asc')->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function get(int $id): array|Collection|String|int|null {
        try {
            if($this->model->where(['id' => $id])->first()) return $this->model->where(['id' => $id])->get();
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->store!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->update!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as2002_kecermatan_soaljawabanRepository->delete!', [
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
