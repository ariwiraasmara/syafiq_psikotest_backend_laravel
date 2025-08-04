<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\UserDeviceHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class userdevicehistoryRepository {

    protected UserDeviceHistory|null $model;
    public function __construct(UserDeviceHistory $model) {
        $this->model = $model;
    }

    public function all(String $sort = 'id_user', String $by = 'asc', String $search): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null || empty($search) || is_null($search)) {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'users_device_history.id_user')
                            ->select('Users.id', 'Users.name', 'Users.email',
                                    'users_device_history.ip_address', 'users_device_history.user_agent', 'users_device_history.last_login')
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
                else {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'users_device_history.id_user')
                            ->select('Users.id', 'Users.name', 'Users.email',
                                    'users_device_history.ip_address', 'users_device_history.user_agent', 'users_device_history.last_login')
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userdevicehistoryRepository->all!', [
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
            if($this->model->where($where)->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'users_device_history.id_user')
                            ->select('Users.id', 'Users.name', 'Users.email',
                                    'users_device_history.ip_address', 'users_device_history.user_agent', 'users_device_history.last_login')
                            ->where($where)
                            ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userdevicehistoryRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userdevicehistoryRepository->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    // ! Fitur ini tidak ada
    // ! Namun tetap dibuat
    public function update(int $id, array $values): array|Collection|String|int|null {
        try {
            $res = $this->model->where(['id' => $id])->update($values);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userdevicehistoryRepository->update!', [
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
            $res = $this->model->where(['id_user' => $id])->delete();
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada userdevicehistoryRepository->delete!', [
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