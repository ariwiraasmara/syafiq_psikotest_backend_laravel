<?php
// ! Copyright @
// ! Syafiq 
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserDeviceHistory;
use App\Models\PersonalAccessTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class userRepository {

    protected User|null $model1;
    protected UserDetail|null $model2;
    public function __construct(
        User $model1,
        UserDetail $model2
    ) {
        $this->model1 = $model1;
        $this->model2 = $model2;
    }

    public function all() {
        try {
            if($this->model1->first()) {
                return $this->model1->select('id', 'name', 'email')
                                    ->orderBy('name', 'asc')
                                    ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function allWithSearch(String $sort = 'name', String $by = 'asc', String $search): array|Collection|String|int|null {
        try {
            if($this->model1->first()) {
                if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null || empty($search) || is_null($search)) {
                    return $this->model1
                            ->select('id', 'name', 'email', 'roles', 'created_at', 'updated_at', 'deleted_at')
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
                else {
                    return $this->model1
                            ->select('id', 'name', 'email', 'roles', 'created_at', 'updated_at', 'deleted_at')
                            ->where($sort, 'LIKE', "%{$search}%")
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->all!', [
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
            if($this->model1->where($where)->first()) return $this->model1->where($where)->get();
            return null;
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

    public function detail(String $type, $val): array|Collection|String|int|null {
        try {
            if($type == 'email') $where = ['users.email' => $val];
            else $where = ['users.id' => $val];
            if($this->model1->where($where)->first()) {
                return $this->model1
                            ->select(
                                'users.id', 'users.name', 'users.email', 'users.password', 'users.roles', 'users.remember_token',
                                'users.created_at', 'users.updated_at', 'users.deleted_at',
                                'users_detail.no_identitas', 'users_detail.tgl_lahir', 'users_detail.jk',
                                'users_detail.alamat', 'users_detail.status', 'users_detail.agama', 'users_detail.foto'
                            )
                            ->join('users_detail', 'users_detail.id', '=', 'users.id')
                            ->where($where)
                            ->get();
            }
                return null;
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

    public function storeAccount(array $values): array|Collection|String|int|null {
        try {
            $res = $this->model1->create($values);
            if($res->id > 0) return $res->id;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->storeAccount!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function storeProfil(array $values): array|Collection|String|int|null {
        try {
            $res = $this->model2->create($values);
            if($res['id'] > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->storeProfil!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function updateAccount(int $id, array $values): array|Collection|String|int|null {
        try {
            $res = $this->model1->where(['id' => $id])->update($values);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->updateAccount!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function updateProfil(int $id, array $values): array|Collection|String|int|null {
        try {
            $res = $this->model2->where(['id' => $id])->update($values);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userRepository->updateProfil!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function softDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->model1->where(['id' => $id])->update(['deleted_at' => date('Y-m-d H:i:s')]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function hardDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->model1->where(['id' => $id])->delete();
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function __destruct() {
        $this->model1 = null;
    }
}