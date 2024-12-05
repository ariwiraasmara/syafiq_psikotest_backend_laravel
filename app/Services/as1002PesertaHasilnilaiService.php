<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1002_peserta_hasilnilaiRepository;
class as1002_peserta_hasilnilaiService {

    protected as1002_peserta_hasilnilaiRepository $repo;
    public function __construct(as1002_peserta_hasilnilaiRepository $repo) {
        $this->repo = $repo;
    }

    public function all() {
        return $this->repo->all();
    }

    public function get(int $id) {
        return $this->repo->get(['id' => $id]);
    }

    public function store(int $id, array $val) {
        $res = $this->repo->store([
            'id1001'             => $id,
            'hasilnilai_kolom_1' => $val['hasilnilai_kolom_1'],
            'hasilnilai_kolom_2' => $val['hasilnilai_kolom_2'],
            'hasilnilai_kolom_3' => $val['hasilnilai_kolom_3'],
            'hasilnilai_kolom_4' => $val['hasilnilai_kolom_4'],
            'hasilnilai_kolom_5' => $val['hasilnilai_kolom_5'],
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function update(int $id, array $val) {
        $res = $this->repo->update($id, [
            'hasilnilai_kolom_1' => $val['hasilnilai_kolom_1'],
            'hasilnilai_kolom_2' => $val['hasilnilai_kolom_2'],
            'hasilnilai_kolom_3' => $val['hasilnilai_kolom_3'],
            'hasilnilai_kolom_4' => $val['hasilnilai_kolom_4'],
            'hasilnilai_kolom_5' => $val['hasilnilai_kolom_5'],
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function delete(int $id) {
        $res = $this->repo->delete($id);
        if($res > 0) return $res;
        return 0;
    }

}