<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Repositories\as2002_kecermatan_soaljawabanRepository;
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

    public function all(int $id) {
        return collect([
            'data1' => $this->repo1->get($id),
            'data2' => $this->repo2->all($id),
        ]);
    }

    public function get(String $kolom, int $id) {
        return collect([
            'soal'     => $this->repo1->get($kolom),
            'jawaban'  => $this->repo2->get($id),
        ]);
    }

    public function store(int $id, array $val) {
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

    public function update(int $id1, int $id2, array $val) {
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

    public function delete(int $id1, int $id2) {
        $res = $this->repo2->delete($id2);

        if($res > 0) {
            $data = $this->repo1->get($id1);
            return collect([
                'kolom_x' => $data[0]['kolom_x'],
                'data'   => $res
            ]);
        }
        return 0;
    }

}