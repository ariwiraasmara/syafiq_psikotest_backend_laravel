<?php 
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as0001_variabelsetting;
class as0001_variabelsettingRepository {

    protected as0001_variabelsetting $model;
    public function __construct(as0001_variabelsetting $model) {
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