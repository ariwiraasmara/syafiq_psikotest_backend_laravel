<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as1001_peserta_profil;
class as1001_peserta_profilRepository {

    protected as1001_peserta_profil $model;
    public function __construct(as1001_peserta_profil $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model
                    ->select('id', 'nama', 'no_identitas', 'email', 'asal')
                    ->orderBy('nama', 'asc')
                    ->get();
    }

    public function allLatest() {
        return $this->model
                    ->distinct()
                    ->select('as1001_peserta_profil.id', 'nama', 'no_identitas', 'email', 'asal', 'as1002_peserta_hasilnilai_teskecermatan.tgl_ujian')
                    ->join('as1002_peserta_hasilnilai_teskecermatan', 'as1002_peserta_hasilnilai_teskecermatan.id1001', '=', 'as1001_peserta_profil.id')
                    ->orderBy('as1002_peserta_hasilnilai_teskecermatan.tgl_ujian', 'desc')
                    ->limit(10)
                    ->get();
    }

    public function get(array $where) {
        if($this->model->where($where)->first()) return $this->model->where($where)->get();
        return null;
    }

    public function store(array $values) {
        $res = $this->model->create($values);
        return $res->id;
    }

    public function update(int $id, array $values) {
        return $this->model->where(['id' => $id])->update($values);
    }

    public function delete(int $id) {
        return $this->model->where(['id' => $id])->delete();
    }

}
?>
