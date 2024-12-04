<?php 
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)

namespace App\Repositories;

use App\Models\as1002_peserta_hasilnilai;

class as1002_peserta_hasilnilaiRepository {

    protected as1002_peserta_hasilnilai $model;
    public function __construct(as1002_peserta_hasilnilai $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function get(array $where) {
        return $this->model->where($where)->get();
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