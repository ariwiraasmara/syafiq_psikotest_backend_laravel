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
class as1002_peserta_hasilnilai_teskecermatanService {

    protected as1001_peserta_profilRepository $repo1;
    protected as1002_peserta_hasilnilai_teskecermatanRepository $repo2;
    public function __construct(
        as1001_peserta_profilRepository $repo1,
        as1002_peserta_hasilnilai_teskecermatanRepository $repo2
    ) {
        $this->repo1 = $repo1;
        $this->repo2 = $repo2;
    }

    public function all($id): array|Collection|String|int|null {
        try {
            return $this->repo2->all(['id1001' => $id]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(int $id, String $tgl): array|Collection|String|int|null {
        try {
            $data = $this->repo1->get(['no_identitas' => $id]);
            return collect([
                'peserta'  => $data,
                'hasiltes' => $this->repo2->get($data[0]['id'], $tgl)
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function search(int $id, String $tgl_1, String $tgl_2): array|Collection|String|int|null {
        try {
            return collect([
                'peserta'  => $this->repo1->get(['id' => $id]),
                'hasiltes' => $this->repo2->search($id, $tgl_1, $tgl_2)
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function store(int $id, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo2->store([
                'id1001'             => $id,
                'tgl_ujian'          => date('Y-m-d H:i:s'),
                'hasilnilai_kolom_1' => $val['hasilnilai_kolom_1'],
                'hasilnilai_kolom_2' => $val['hasilnilai_kolom_2'],
                'hasilnilai_kolom_3' => $val['hasilnilai_kolom_3'],
                'hasilnilai_kolom_4' => $val['hasilnilai_kolom_4'],
                'hasilnilai_kolom_5' => $val['hasilnilai_kolom_5'],
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->store!', [
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
            $res = $this->repo2->update($id, [
                'hasilnilai_kolom_1' => $val['hasilnilai_kolom_1'],
                'hasilnilai_kolom_2' => $val['hasilnilai_kolom_2'],
                'hasilnilai_kolom_3' => $val['hasilnilai_kolom_3'],
                'hasilnilai_kolom_4' => $val['hasilnilai_kolom_4'],
                'hasilnilai_kolom_5' => $val['hasilnilai_kolom_5'],
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->update!', [
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
            $res = $this->repo2->delete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as1002_peserta_hasilnilai_teskecermatanService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}
