<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as5001_blog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as5001_blogRepository {

    protected as5001_blog|null $model;
    public function __construct(as5001_blog $model) {
        $this->model = $model;
    }

    public function all(String $sort = 'title', String $by = 'asc', String $search): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null || empty($search) || is_null($search)) {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('as5001_blog.id', 'as5001_blog.id_user', 'Users.name',
                                    'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.status',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at')
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
                else {
                    return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('as5001_blog.id', 'as5001_blog.id_user', 'Users.name',
                                    'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.status',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
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
            if($this->model->where($where)->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('as5001_blog.id', 'Users.name',
                                    'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.content', 'as5001_blog.pictures', 'as5001_blog.status',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
                            ->where($where)
                            ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function publicAll() {
        try {
            if($this->model->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('Users.name', 'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.content', 'as5001_blog.pictures',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
                            ->orderBy('as5001_blog.created_at', 'desc')
                            ->where(['status' => 'public'])
                            ->limit(9)
                            ->paginate(9)
                            ->toArray();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function publicRecent($recent) {
        try {
            if($this->model->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('Users.name', 'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.content', 'as5001_blog.pictures',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
                            ->orderBy('as5001_blog.created_at', 'desc')
                            ->where(['status' => 'public'])
                            ->limit($recent)
                            ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function publicSearch($field, $search) {
        try {
            if($this->model->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('Users.name', 'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.content', 'as5001_blog.pictures',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
                            ->orderBy('as5001_blog.created_at', 'desc')
                            ->where(['status' => 'public'])
                            ->where($field, 'LIKE', "%{$search}%")
                            ->limit(9)
                            ->paginate(9)
                            ->toArray();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function publicDetail(String $title) {
        try {
            $where = ['title' => $title];
            if($this->model->where($where)->first()) {
                return $this->model
                            ->join('Users', 'Users.id', '=', 'as5001_blog.id_user')
                            ->select('Users.name', 'as5001_blog.title', 'as5001_blog.category', 'as5001_blog.content', 'as5001_blog.pictures',
                                    'as5001_blog.created_at', 'as5001_blog.updated_at', 'as5001_blog.deleted_at',)
                            ->where($where)
                            ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function check($where, String $type = 'first') {
        try {
            if($this->model->where($where)->first()) {
                $data = $this->model->where($where)->first();
                if($type == 'first') return $data;
                else {
                    if($data->id > 0) return $data->id;
                    return 0;
                }
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->get!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->store!', [
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
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as0001_variabelsettingRepository->update!', [
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
        $this->model = null;
    }
}