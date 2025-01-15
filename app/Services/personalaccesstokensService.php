<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\personalaccesstokensRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Libraries\myfunction as fun;
use Exception;
class personalaccesstokensService {

    protected personalaccesstokensRepository $repo;
    public function __construct() {
        $this->repo = new personalaccesstokensRepository();
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            $data = $this->repo->get($where);
            // cek tanggal kadaluarsa
            if($data[0]['expires_at'] ==  date('Y-m-d 00:00:00')) {
                $this->update($data[0]['id'],[
                    'expires_at' => fun::daysLater('+7 days')
                ]);
            }
            return $data;
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

    public function update(int $id, array $val): String|int|null {
        try {
            $res = $this->repo->update($id, $val);
            if($res > 0) {
                $data = $this->repo->get(['id' => $id]);
                Log::channel('debugging')->debug('Token Telah Diupdate!', [
                    'tanggal' => date('Y-m-d H:i:s')
                ]);
                return (String)$id.'|'.$data[0]['token'];
            }
            return 0;
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