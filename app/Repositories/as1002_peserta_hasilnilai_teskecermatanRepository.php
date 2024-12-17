<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as1002_peserta_hasilnilai_teskecermatan;
class as1002_peserta_hasilnilai_teskecermatanRepository {

    protected as1002_peserta_hasilnilai_teskecermatan $model;
    public function __construct(as1002_peserta_hasilnilai_teskecermatan $model) {
        $this->model = $model;
    }

    public function all(array $where) {
        return $this->model->where($where)->get();
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
