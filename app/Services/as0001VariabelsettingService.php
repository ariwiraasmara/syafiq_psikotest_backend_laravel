<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\as0001_variabelsettingRepository;
class as0001_variabelsettingService {

    protected as0001_variabelsettingRepository $repo;
    public function __construct(as0001_variabelsettingRepository $repo) {
        $this->repo = $repo;
    }

    public function all() {
        return $this->repo->all();
    }

    public function get(int $id) {
        return $this->repo->get(['id' => $id]);
    }

    public function store(array $val) {
        $res = $this->repo->store([
            'variabel'      => $val['variabel'],
            'values'        => $val['values'],
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function update(int $id, array $val) {
        $res = $this->repo->update($id, [
            'variabel'      => $val['variabel'],
            'values'        => $val['values'],
            'updated_at'    => now(),
        ]);
        if($res > 0) return $res;
        return 0;
    }

    public function delete(int $id) {
        $res = $this->repo->delete($id);
        if($res > 0) return $res;
        return 0;
    }
}