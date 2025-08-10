<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Services;

use App\Repositories\userRepository;
use App\Repositories\useractivitiesRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Libraries\myfunction as fun;
use Browser;
use Exception;
class useractivitiesService {

    protected useractivitiesRepository|null $repo;
    protected userRepository|null $user;
    public function __construct(
        useractivitiesRepository $repo,
        userRepository $user
    ) {
        $this->repo = $repo;
        $this->user = $user;
    }

    public function all(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            return $this->repo->all($sort, $by, $search);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(String $type, array $where, String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            return $this->repo->get($type, $where, $sort, $by, $search);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->get!', [
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
                'ip_address' => $val['ip_address'],
                'path'       => $val['path'],
                'url'        => $val['url'],
                'page'       => $val['page'],
                'event'      => $val['event'],
                'deskripsi'  => $val['deskripsi'],
                'properties' => $val['properties'],
                'user_agent' => Browser::userAgent(),
                'tanggal'    => date('Y-m-d H:i:s')
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    // ! Fitur ini tidak ada
    // ! Namun tetap dibuat
    public function update(int $id, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo->update($id, [
                'id_user'    => $val['id_user'],
                'path'       => $val['path'],
                'url'        => $val['url'],
                'page'       => $val['page'],
                'event'      => $val['event'],
                'deskripsi'  => $val['deskripsi'],
                'properties' => $val['properties'],
                'ip_address' => $val['ip_address'],
                'user_agent' => $val['user_agent'],
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function delete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo->delete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function truncate(): array|Collection|String|int|null {
        try {
            $res = $this->repo->truncate();
            if($res) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function backupAll(): array|Collection|String|int|null {
        try {
            $res = $this->repo->backupAll();
            if($res) {
                $filename = 'backup_all_'.date('Ymd').'.json';
                Storage::disk('download')->put($filename, $res);
                return collect([
                    'success'  => 1,
                    'filename' => storage_path('app/private/download/'.$filename)
                ]);
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function backupUser($id): array|Collection|String|int|null {
        try {
            $res = $this->repo->backupUser($id);
            if($res) {
                $user = $this->user->get(['id'=>$id]);
                $filename = 'backup_'.$user[0]['email'].'_'.date('Ymd').'.json';
                Storage::disk('download')->put($filename, $res->toJson());
                return collect([
                    'success'  => 1,
                    'filename' => storage_path('app/private/download/'.$filename)
                ]);
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada useractivitiesRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function __destruct() {
        $this->repo = null;
    }
}