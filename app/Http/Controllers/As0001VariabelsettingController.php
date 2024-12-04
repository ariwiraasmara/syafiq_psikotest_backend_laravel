<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\as0001_variabelsettingRepository;
use App\Libraries\jsr;

class As0001VariabelsettingController extends Controller {
    //
    protected as0001_variabelsettingRepository $repo;
    public function __construct(as0001_variabelsettingRepository $repo) {
        $this->repo = $repo;
    }

    #GET
    public function all() {
        $data = $this->repo->all();
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Setting Variabel',
            'data'      => $data
        ], 'ok');
    }

    #GET
    public function get(int $id) {
        $data = $this->repo->get(['id' => $id]);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Setting Variabel',
            'data'      => $data
        ], 'ok');
    }

    #POST
    public function store(Request $request) {
        $data = $this->repo->store([
            'variabel'      => $request->variabel,
            'values'        => $request->values,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menyimpan Data Setting Variabel',
            'data'      => $data
        ], 'created');
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        $data = $this->repo->update($id, [
            'variabel'      => $request->variabel,
            'values'        => $request->values,
            'updated_at'    => now(),
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Memperbaharui Data Setting Variabel',
            'data'      => $data
        ], 'ok');
    }

    #POST/DELETE
    public function delete(int $id) {
        $data = $this->repo->delete($id);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Setting Variabel',
        ], 'ok');
    }
}
