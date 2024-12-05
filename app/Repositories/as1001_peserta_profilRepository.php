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
                    ->all();
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