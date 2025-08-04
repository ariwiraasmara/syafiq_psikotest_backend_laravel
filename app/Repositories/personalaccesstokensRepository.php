<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\PersonalAccessTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class personalaccesstokensRepository {

    protected PersonalAccessTokens|null $model;
    public function __construct() {
        $this->model = new PersonalAccessTokens();
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) return $this->model->where($where)->get();
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada personalaccesstokensRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada personalaccesstokensRepository->store!', [
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
            else return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada personalaccesstokensRepository->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function __destruct() {
        $this->model = null;
    }
}