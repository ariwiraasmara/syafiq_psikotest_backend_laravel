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

    public function all() {
        return $this->model->all();
    }

    public function get(array $where) {
        $res = $this->model->where($where);
        if($res->first()) return $res->get();
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