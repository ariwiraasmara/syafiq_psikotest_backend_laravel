<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1001_peserta_profilRepository;
class as1001_peserta_profilService {

    protected as1001_peserta_profilRepository $repo;
    public function __construct(as1001_peserta_profilRepository $repo) {
        $this->repo = $repo;
    }

    public function allProfil() {
        return $this->repo->all();
    }

    public function get(String $no_identitas) {
        return $this->repo->get(['no_identitas' => $no_identitas]);
    }

    public function store(array $val) {
        $res = $this->repo->store([
            'nama'          => $val['nama'],
            'no_identitas'  => $val['no_identitas'],
            'email'         => $val['email'],
            'tgl_lahir'     => $val['tgl_lahir'],
            'usia'          => $val['usia'],
            'asal'          => $val['asal'],
            'tgl_ujian'     => $val['tgl_ujian'],
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function update(int $id, array $val) {
        $res = $this->repo->update($id, [
            'email'         => $val['email'],
            'tgl_lahir'     => $val['tgl_lahir'],
            'usia'          => $val['usia'],
            'asal'          => $val['asal'],
            'tgl_ujian'     => $val['tgl_ujian'],
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