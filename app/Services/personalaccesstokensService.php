<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\personalaccesstokensRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Libraries\myfunction as fun;
use Exception;
class personalaccesstokensService {

    protected personalaccesstokensRepository $repo;
    public function __construct() {
        $this->repo = new personalaccesstokensRepository();
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            return $this->repo->get($where);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada personalaccesstokensService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function store(array $val) {
        $res = $this->repo->store([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id'   => $val['user_id'],
            'name'           => $val['email'],
            'token'          => Str::random(64),
            'abilities'      => $val['abilities'],
            'created_at'     => now(),
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function update(int $id, array $val): String|int|null {
        try {
            $res = $this->repo->update($id, $val);
            if($res > 0) {
                $data = $this->repo->get(['id' => $id]);
                // return (String)$id.'|'.$data[0]['token'];
                return $id.'|'.$data[0]['token'];
            }
            else {
                return 0;
            }
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada personalaccesstokensService->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}
?>