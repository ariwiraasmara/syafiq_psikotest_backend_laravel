<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\as1002_peserta_hasilnilaiRepository;
use App\Libraries\jsr;

class As1001PesertaHasilnilaiController extends Controller {
    //
    protected as1002_peserta_hasilnilaiRepository $repo;
    public function __construct(as1002_peserta_hasilnilaiRepository $repo) {
        $this->repo = $repo;
        
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Hasil Nilai Peserta Ujian!', 
            'data'      => $this->repo->all()
        ], 'ok'); 
    }

    #GET
    public function get(int $id) {
        $data = $this->repo->get(['id' => $id]);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Hasil Nilai Peserta '.$data[0]['nama'], 
            'data'      => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request, int $id) {
        $data = $this->repo->store([
            'id1001'             => $id,
            'hasilnilai_kolom_1' => $request->hasilnilai_kolom_1,
            'hasilnilai_kolom_2' => $request->hasilnilai_kolom_2,
            'hasilnilai_kolom_3' => $request->hasilnilai_kolom_3,
            'hasilnilai_kolom_4' => $request->hasilnilai_kolom_4,
            'hasilnilai_kolom_5' => $request->hasilnilai_kolom_5,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menyimpan Data Hasil Nilai Peserta Tes!', 
            'data'      => $data
        ], 'created'); 
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        return $this->repo->update($id, [
            'hasilnilai_kolom_1' => $request->hasilnilai_kolom_1,
            'hasilnilai_kolom_2' => $request->hasilnilai_kolom_2,
            'hasilnilai_kolom_3' => $request->hasilnilai_kolom_3,
            'hasilnilai_kolom_4' => $request->hasilnilai_kolom_4,
            'hasilnilai_kolom_5' => $request->hasilnilai_kolom_5,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Memperbaharui Data Hasil Nilai Peserta Tes!', 
            'data'      => $data
        ], 'ok'); 
    }

    #DELETE/POST
    public function delete(int $id) {
        $data = $this->repo->delete($id);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Hasil Nilai Peserta Tes!', 
        ], 'ok'); 
    }
}
