<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Libraries\jsr;
class As2001KecermatanKolompertanyaanController extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanService $service;
    public function __construct(as2001_kecermatan_kolompertanyaanService $service) {
        $this->service = $service;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Soal Psikotest Kecermatan!', 
            'data'      => $this->service->all()
        ], 'ok'); 
    }

    #GET
    public function get(String|int $val) {
        $data = $this->service->get($val);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Pertanyaan Psikotest Kecermatan '.$data[0]['kolom_x'], 
            'data'      => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request) {
        $data = $this->service->store([
            'kolom_x' => $request->kolom_x,
            'nilai_A' => $request->nilai_A,
            'nilai_B' => $request->nilai_B,
            'nilai_C' => $request->nilai_C,
            'nilai_D' => $request->nilai_D,
            'nilai_E' => $request->nilai_E,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menyimpan Data Pertanyaan Psikotest Kecermatan!', 
            'data'    => $data
        ], 'created');

        return jsr::print([
            'error'   => 1,
            'pesan'   => 'Gagal Menyimpan Data Pertanyaan Psikotest Kecermatan!', 
        ], 'bad request');
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        $data = $this->service->update($id, [
            'nilai_A' => $request->nilai_A,
            'nilai_B' => $request->nilai_B,
            'nilai_C' => $request->nilai_C,
            'nilai_D' => $request->nilai_D,
            'nilai_E' => $request->nilai_E,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Memperbaharui Data Pertanyaan Psikotest Kecermatan!', 
            'data'    => $data
        ], 'ok');

        return jsr::print([
            'error'   => 1,
            'pesan'   => 'Gagal Memperbaharui Data Pertanyaan Psikotest Kecermatan!', 
        ], 'bad request');
    }

    #DELETE/POST
    public function delete(int $id) {
        $data = $this->service->delete($id);
        
        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menghapus Data Soal Pertanyaan Kecermatan!', 
        ], 'ok');

        return jsr::print([
            'error'   => 1,
            'pesan'   => 'Gagal Menghapus Data Soal Pertanyaan Kecermatan!', 
        ], 'bad request');
    }
}
