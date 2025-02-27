<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1001_peserta_profilRepository;
use App\Repositories\as1002_peserta_hasilnilai_teskecermatanRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;

class as1001_peserta_profilService {

    protected as1001_peserta_profilRepository $repo1;
    protected as1002_peserta_hasilnilai_teskecermatanRepository $repo2;
    public function __construct(
        as1001_peserta_profilRepository $repo1,
        as1002_peserta_hasilnilai_teskecermatanRepository $repo2
    ) {
        $this->repo1 = $repo1;
        $this->repo2 = $repo2;
    }

    public function allProfil(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            if($search == 'null' || $search == '' || $search == ' ' || $search == null) $search = null;
            return $this->repo1->all($sort, $by, $search);
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
            return $this->repo1->allLatest();
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
            return $this->repo1->get(['id' => $id]);
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
            $cek1 = $this->repo1->get(['no_identitas' => $val['no_identitas']]);
            if($cek1) return collect(['error' => 1, 'pesan' => 'Gagal Menyimpan Data Peserta Tes! Data Peserta ini sudah ada!']);
            $datenow = date('Y');
            $tgl_lahir = date('Y', strtotime($val['tgl_lahir']));
            $usia = $datenow - $tgl_lahir;
            $res = $this->repo1->store([
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
            $res = $this->repo1->update($id, [
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
            $cek1 = $this->repo1->get(['no_identitas' => $val['no_identitas']]);
            if($cek1) { 
                //? Apakah peserta sudah terdaftar
                $cek2 = $this->repo2->getCheckTesDate($cek1[0]['id'], $val['tgl_tes']);
                if($cek2) { 
                    //? Apakah peserta sudah mengambil tes hari ini
                    return collect(['success' => 'datex', 'status' => 'Exist!']);
                }
                else {
                    if($cek1[0]['email'] != $val['email'] || $cek1[0]['tgl_lahir'] != $val['tgl_lahir'] || $cek1[0]['asal'] != $val['asal']) {
                        //? Apakah data peserta antara database dan inputan adalah sama?
                        $res = $this->update($cek1[0]['id'], $val);
                        if($res > 0) return collect(['success' => 1, 'status' => 'Update', 'res' => $res]);
                        return 'err2';
                    }
                    //? Jika tidak maka tak perlu update
                    return collect(['success' => 1, 'status' => 'Unnecessary Update', 'res' => $cek1[0]['id']]);
                }
            }
            //? Jika peserta belum terdaftar
            $res = $this->store($val);
            if($res > 0) return collect(['success' => 1, 'status' => 'Insert', 'res' => $res]);
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
            $res = $this->repo1->delete($id);
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
