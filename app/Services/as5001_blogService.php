<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as5001_blogRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Libraries\myfunction as fun;
class as5001_blogService {

    protected as5001_blogRepository $repo;
    public function __construct(as5001_blogRepository $repo) {
        $this->repo = $repo;
    }

    public function all(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            return $this->repo->all($sort, $by, $search);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(int $id): array|Collection|String|int|null {
        try {
            return $this->repo->get(['as5001_blog.id' => $id]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function publicAll(): array|Collection|String|int|null {
        try {
            return $this->repo->publicAll();
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function publicRecent(int $recent): array|Collection|String|int|null {
        try {
            return $this->repo->publicRecent($recent);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function publicSearch(String $field, String $title): array|Collection|String|int|null {
        try {
            return $this->repo->publicSearch($field, $title);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function publicDetail(String $title): array|Collection|String|int|null {
        try {
            return $this->repo->publicDetail($title);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->get!', [
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
                'id_user'    => $val['id_user'],
                'title'      => $val['title'],
                'category'   => $val['category'],
                'status'     => $val['status'],
                'content'    => $val['content'],
                'created_at' => $val['created_at'],
                'updated_at' => $val['created_at'],
                'deleted_at' => null,
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->store!', [
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
                'title'      => $val['title'],
                'category'   => $val['category'],
                'status'     => $val['status'],
                'content'    => $val['content'],
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function softDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo->update($id, [
                'deleted_at' => now(),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function hardDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo->delete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as5001_blogService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}