<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as2002_kecermatan_soaljawaban;
class as2002_kecermatan_soaljawabanRepository {

    protected as2002_kecermatan_soaljawaban $model;
    public function __construct(as2002_kecermatan_soaljawaban $model) {
        $this->model = $model;
    }

    public function all(int $id) {
        // return $this->model->where(['id2001' => $id])->get();
        return $this->model->where(['id2001' => $id])->paginate(10);
    }

    public function all50(int $id) {
        return $this->model->where(['id2001' => $id])
                    ->orderBy('id', 'asc')
                    ->limit(50)
                    ->get();
    }

    public function get(int $id) {
        return $this->model->where(['id' => $id])
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
