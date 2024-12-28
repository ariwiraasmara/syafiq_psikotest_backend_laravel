<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\PersonalAccessTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class personalaccesstokensRepository {

    protected PersonalAccessTokens $model;
    public function __construct() {
        $this->model = new PersonalAccessTokens();
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) return $this->model->where($where)->get();
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }
}