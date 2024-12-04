<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\User;
class userRepository {

    protected User $model;
    public function __construct(User $model) {
        $this->model = $model;
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

}