<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1001_peserta_profilRepository;
use App\Repositories\as1002_peserta_hasilnilai_teskecermatanRepository;
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

    public function all($id) {
        return $this->repo2->all(['id1001' => $id]);
    }

    public function get(int $id, String $tgl) {
        $data = $this->repo1->get(['no_identitas' => $id]);
        return collect([
            'peserta'  => $data,
            'hasiltes' => $this->repo2->get(['id' => $data[0]['id'], 'tgl_ujian' => $tgl])
        ]);
    }

    public function store(int $id, array $val) {
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

    public function update(int $id, array $val) {
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

    public function delete(int $id) {
        $res = $this->repo2->delete($id);
        if($res > 0) return $res;
        return 0;
    }

}
