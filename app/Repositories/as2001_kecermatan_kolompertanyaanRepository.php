<?php 
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)

namespace App\Repositories;

use App\Models\as2001_kecermatan_kolompertanyaan;

class as2001_kecermatan_kolompertanyaanRepository {

    protected as2001_kecermatan_kolompertanyaan $model;
    public function __construct(as2001_kecermatan_kolompertanyaan $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->select('id', 'kolom_x')->all();
    }

    public function get(String|int $val) {
        return $this->model
                    ->where(['id' => $val])
                    ->Orwhere(['kolom_x' => $val])
                    ->get();
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