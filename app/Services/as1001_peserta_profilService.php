<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1001_peserta_profilRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as1001_peserta_profilService {

    protected as1001_peserta_profilRepository $repo;
    public function __construct(as1001_peserta_profilRepository $repo) {
        $this->repo = $repo;
    }

    public function allProfil(): array|Collection|String|int|null {
        try {
            return $this->repo->all();
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->allProfil!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function allLatest(): array|Collection|String|int|null {
        try {
            return $this->repo->allLatest();
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->allLatest!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(String $id): array|Collection|String|int|null {
        try {
            return $this->repo->get(['id' => $id]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->get!', [
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
            $cek1 = $this->repo->get(['no_identitas' => $val['no_identitas']]);
            if($cek1) return collect(['error' => 1, 'pesan' => 'Gagal Menyimpan Data Peserta Tes! Data Peserta ini sudah ada!']);
            $datenow = date('Y');
            $tgl_lahir = date('Y', strtotime($val['tgl_lahir']));
            $usia = $datenow - $tgl_lahir;
            $res = $this->repo->store([
                'nama'          => $val['nama'],
                'no_identitas'  => $val['no_identitas'],
                'email'         => $val['email'],
                'tgl_lahir'     => $val['tgl_lahir'],
                'usia'          => $usia,
                'asal'          => $val['asal'],
            ]);
            if($res > 0) return $res;
            return 0; //collect(['error' => 2, 'pesan' => 'Gagal Menyimpan Data Peserta Tes!']);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->store!', [
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
            $datenow = date('Y');
            $tgllahir = date('Y', strtotime($val['tgl_lahir']));
            $usia = $datenow - $tgllahir;
            $res = $this->repo->update($id, [
                'email'         => $val['email'],
                'tgl_lahir'     => $val['tgl_lahir'],
                'usia'          => $usia,
                'asal'          => $val['asal'],
            ]);
            if($res > 0) return $id;
            return 0; //collect(['error' => 1, 'pesan' => 'Gagal Memperbaharui Data Peserta Tes!']);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function setUpPesertaTes(array $val): array|Collection|String|int|null {
        try {
            $cek = $this->repo->get(['no_identitas' => $val['no_identitas']]);
            if($cek) {
                if($cek[0]['email'] != $val['email'] || $cek[0]['tgl_lahir'] != $val['tgl_lahir'] || $cek[0]['asal'] != $val['asal']) {
                    $res = $this->update($cek[0]['id'], $val);
                    if($res > 0) return collect(['success' => true, 'status' => 'Update', 'res' => $res]);
                    return 'err2';
                }
                return collect(['success' => true, 'status' => 'Tidak Perlu Update', 'res' => $cek[0]['id']]);
            }
            $res = $this->store($val);
            if($res > 0) return collect(['success' => true, 'status' => 'Insert', 'res' => $res]);
            return $res;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->setUpPesertaTes!', [
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
            Log::channel('error-services')->error('Terjadi kesalahan pada as1001_peserta_profilService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}
