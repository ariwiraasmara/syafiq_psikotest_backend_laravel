<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Repositories\as2002_kecermatan_soaljawabanRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as2002_kecermatan_soalService {

    protected as2001_kecermatan_kolompertanyaanRepository $repo1;
    protected as2002_kecermatan_soaljawabanRepository $repo2;
    public function __construct(
        as2001_kecermatan_kolompertanyaanRepository $repo1,
        as2002_kecermatan_soaljawabanRepository $repo2
    ) {
        $this->repo1 = $repo1;
        $this->repo2 = $repo2;
    }

    public function json() {
        $data2 = $this->repo2->all(1); // ambil semua data berdasarkan id2001 dimana idnya pada tabel 2001_kecermatan_kolompertanyaan
        $soal = []; // inisialisasi untuk menampung data soal dari "soal_jawaban"
        $jawaban = []; // inisialisasi untuk menampung data jawaban dari "soal_jawaban"
        foreach ($data2 as $item) {
            // Ambil soal dan jawaban untuk setiap data
            $soal[] = $item->soal_jawaban['soal'][0]; // Mengambil soal yang ada di dalam array 'soal'
            $jawaban[] = $item->soal_jawaban['jawaban']; // Mengambil jawaban
        }

        $soal = array_map("serialize", $soal); // Serialisasi array untuk membandingkan array multidimensi
        $soal = array_unique($soal); // Menghapus duplikasi
        $soal = array_map("unserialize", $soal); // Mengembalikan ke bentuk semula

        return $soal;
    }

    public function all(int $id): array|Collection|String|int|null {
        try {
            $data2 = $this->repo2->all($id);
            // return $data2;
            $data1 = $this->repo1->get($data2[0]['id2001']);
            return collect([
                'pertanyaan'  => $data1,
                'soaljawaban' => $data2
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2002_kecermatan_soalService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get(String|int $kolom): array|Collection|String|int|null {
        try {
            $data1 = $this->repo1->get($kolom);
            $data2 = $this->repo2->all50($data1[0]['id']); // ambil semua data berdasarkan id2001 dimana idnya pada tabel 2001_kecermatan_kolompertanyaan
            $soal = []; // inisialisasi untuk menampung data soal dari "soal_jawaban"
            $jawaban = []; // inisialisasi untuk menampung data jawaban dari "soal_jawaban"
            foreach ($data2 as $item) {
                if (isset($item->soal_jawaban['soal'][0]) && isset($item->soal_jawaban['jawaban'])) {
                    $soal[] = $item->soal_jawaban['soal'][0];
                    $jawaban[] = $item->soal_jawaban['jawaban'];
                } else {
                    // Bisa menambahkan log atau debugging untuk melihat data yang hilang
                    Log::info("Data soal/jawaban tidak lengkap: ", $item);
                }
            }
            // $soal = array_map("serialize", $soal); // Serialisasi array untuk membandingkan array multidimensi
            //dd($soal); // Periksa soal setelah serialisasi
            // $soal = array_unique($soal); // Menghapus duplikasi
            //dd($soal); // Periksa soal setelah duplikasi dihapus
            // $soal = array_map("unserialize", $soal); // Mengembalikan ke bentuk semula
            return collect([
                'pertanyaan' => $this->repo1->get($kolom),
                'soal'       => $soal,
                'jawaban'    => $jawaban
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2002_kecermatan_soalService->get!', [
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
                'id2001'       => $id,
                'soal_jawaban' => $val['soal_jawaban'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
            if($res > 0) {
                $data = $this->repo1->get($id);
                return collect([
                    'kolom_x' => $data[0]['kolom_x'],
                    'data'   => $res
                ]);
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2002_kecermatan_soalService->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function update(int $id1, int $id2, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo2->update($id2, [
                'soal_jawaban' => $val['soal_jawaban'],
                'updated_at'   => now(),
            ]);
            if($res > 0) {
                $data = $this->repo1->get($id1);
                return collect([
                    'kolom_x' => $data[0]['kolom_x'],
                    'data'   => $res
                ]);
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2002_kecermatan_soalService->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function delete(int $id1, int $id2): array|Collection|String|int|null {
        try {
            $res = $this->repo2->delete($id2);
            if($res > 0) {
                $data = $this->repo1->get($id1);
                return collect([
                    'success' => 1,
                    'kolom_x' => $data[0]['kolom_x'],
                    'data'    => $res
                ]);
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada as2002_kecermatan_soalService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }
}
