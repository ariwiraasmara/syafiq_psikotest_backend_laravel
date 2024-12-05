<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
class as2001_kecermatan_kolompertanyaanService {

    protected as2001_kecermatan_kolompertanyaanRepository $repo;
    public function __construct(as2001_kecermatan_kolompertanyaanRepository $repo) {
        $this->repo = $repo;
    }

    public function all() {
        return $this->repo->all();
    }

    public function get(String|int $val) {
        return $this->repo->get($val);
    }

    public function store(array $val) {
        $res = $this->repo->store([
            'kolom_x'    => $val['kolom_x'],
            'nilai_A'    => $val['nilai_A'],
            'nilai_B'    => $val['nilai_B'],
            'nilai_C'    => $val['nilai_C'],
            'nilai_D'    => $val['nilai_D'],
            'nilai_E'    => $val['nilai_E'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function update(int $id, array $val) {
        $res = $this->repo->update($id, [
            'nilai_A'    => $val['nilai_A'],
            'nilai_B'    => $val['nilai_B'],
            'nilai_C'    => $val['nilai_C'],
            'nilai_D'    => $val['nilai_D'],
            'nilai_E'    => $val['nilai_E'],
            'updated_at' => now(),
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