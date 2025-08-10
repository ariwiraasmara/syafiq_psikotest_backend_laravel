<?php 
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Repositories;

use App\Models\UserActivities;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
class useractivitiesRepository {

    protected UserActivities|null $model;
    public function __construct(UserActivities $model) {
        $this->model = $model;
    }

    public function all(String $sort = 'name', String $by = 'asc', String $search): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null || empty($search) || is_null($search)) {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'users_activities.id_user')
                            ->select('users_activities.id', 'users_activities.id_user', 'Users.name', 'Users.email',
                                    'users_activities.ip_address', 'users_activities.path', 'users_activities.url',
                                    'users_activities.page', 'users_activities.event', 'users_activities.deskripsi',
                                    'users_activities.properties', 'users_activities.user_agent', 'users_activities.tanggal',
                                    )
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
                else {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'users_activities.id_user')
                            ->select('users_activities.id', 'users_activities.id_user', 'Users.name', 'Users.email',
                                    'users_activities.ip_address', 'users_activities.path', 'users_activities.url',
                                    'users_activities.page', 'users_activities.event', 'users_activities.deskripsi',
                                    'users_activities.properties', 'users_activities.user_agent', 'users_activities.tanggal',
                                    )
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function get($type, array $where, String $sort = 'id', String $by = 'asc', String $search): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) {
                if($type == 'user'){
                    return $this->model
                                ->limit(10)
                                ->paginate(10)
                                ->toArray();
                }
                else {
                    return $this->model
                                ->where($where)
                                ->get();
                }
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->store!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->update!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function truncate(): array|Collection|String|int|null {
        try {
            DB::table($this->model->getTable())->truncate();
            return 1;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function backupAll(): array|Collection|String|int|null {
        try {
            return $this->model->get();
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function backupUser(int $id): array|Collection|String|int|null {
        try {
            $res = $this->model->where(['id_user' => $id])->get();
            if($res) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
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