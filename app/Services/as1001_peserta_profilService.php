<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as1001_peserta_profilRepository;
use App\Services\DateTime;
class as1001_peserta_profilService {

    protected as1001_peserta_profilRepository $repo;
    public function __construct(as1001_peserta_profilRepository $repo) {
        $this->repo = $repo;
    }

    public function allProfil() {
        return $this->repo->all();
    }

    public function get(String $id) {
        return $this->repo->get(['id' => $id]);
    }

    public function store(array $val) {
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
        return collect(['error' => 2, 'pesan' => 'Gagal Menyimpan Data Peserta Tes!']);
    }

    public function update(int $id, array $val) {
        $datenow = date('Y');
        $tgllahir = date('Y', strtotime($val['tgl_lahir']));
        $usia = $datenow - $tgllahir;
        $res = $this->repo->update($id, [
            'email'         => $val['email'],
            'tgl_lahir'     => $val['tgl_lahir'],
            'usia'          => $usia,
            'asal'          => $val['asal'],
        ]);
        if($res > 0) return $res;
        return collect(['error' => 1, 'pesan' => 'Gagal Memperbaharui Data Peserta Tes!']);
    }

    public function setUpPesertaTes(array $val) {
        $cek = $this->repo->get(['no_identitas' => $val['no_identitas']]);

        if(!is_null($cek)) {
            $res = $this->update($cek[0]['id'], $val);
            if($res > 0) return collect(['status' => 'Update', 'data' => $res]);
            return 'err2';
        }

        $res = $this->store($val);
        if($res > 0) return collect(['status' => 'Insert', 'data' => $res]);
        return $res;
    }

    public function delete(int $id) {
        $res = $this->repo->delete($id);
        if($res > 0) return $res;
        return 0;
    }

}