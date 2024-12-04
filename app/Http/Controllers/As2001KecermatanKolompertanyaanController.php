<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;

class As2001KecermatanKolompertanyaanController extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanRepository $repo;
    public function __construct(as2001_kecermatan_kolompertanyaanRepository $repo) {
        $this->repo = $repo;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Soal Psikotest Kecermatan!', 
            'data'      => $this->repo->all()
        ], 'ok'); 
    }

    #GET
    public function get(String|int $val) {
        $data = $this->repo->get($val);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Soal Psikotest Kecermatan '.$data[0]['kolom_x'], 
            'data'      => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request) {
        $data = $this->repo->store([
            'kolom_x' => $request->kolom_x,
            'nilai_1' => $request->nilai_1,
            'nilai_2' => $request->nilai_2,
            'nilai_3' => $request->nilai_3,
            'nilai_4' => $request->nilai_4,
            'nilai_5' => $request->nilai_5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menyimpan Data Soal Psikotest Kecermatan!', 
            'data'      => $data
        ], 'created'); 
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        return $this->repo->update($id, [
            'nilai_1' => $request->nilai_1,
            'nilai_2' => $request->nilai_2,
            'nilai_3' => $request->nilai_3,
            'nilai_4' => $request->nilai_4,
            'nilai_5' => $request->nilai_5,
            'updated_at' => now(),
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Memperbaharui Data Soal Psikotest Kecermatan!', 
            'data'      => $data
        ], 'ok'); 
    }

    #DELETE/POST
    public function delete(int $id) {
        $data = $this->repo->delete($id);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Soal Psikotest Kecermatan!', 
        ], 'ok'); 
    }
}
