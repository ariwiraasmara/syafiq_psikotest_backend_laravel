<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Libraries\jsr;
class As1002PesertaHasilnilaiTesKecermatanController extends Controller {
    //
    protected as1002_peserta_hasilnilai_teskecermatanService $service;
    public function __construct(as1002_peserta_hasilnilai_teskecermatanService $service) {
        $this->service = $service;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Hasil Nilai Peserta Ujian!', 
            'data'      => $this->service->all()
        ], 'ok'); 
    }

    #GET
    public function get(int $id) {
        $data = $this->service->get($id);
        return jsr::print([
            'success' => 1,
            'pesan'   => 'Data Hasil Nilai Peserta '.$data['peserta'][0]['nama'], 
            'data'    => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request, int $id) {
        $data = $this->service->store($id, [
            'hasilnilai_kolom_1' => $request->hasilnilai_kolom_1,
            'hasilnilai_kolom_2' => $request->hasilnilai_kolom_2,
            'hasilnilai_kolom_3' => $request->hasilnilai_kolom_3,
            'hasilnilai_kolom_4' => $request->hasilnilai_kolom_4,
            'hasilnilai_kolom_5' => $request->hasilnilai_kolom_5,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menyimpan Data Hasil Nilai Peserta Tes!', 
            'data'    => $data
        ], 'created');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Menyimpan Data Hasil Nilai Peserta Tes!', 
            'data'  => $data
        ], 'bad request');
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        return $this->service->update($id, [
            'hasilnilai_kolom_1' => $request->hasilnilai_kolom_1,
            'hasilnilai_kolom_2' => $request->hasilnilai_kolom_2,
            'hasilnilai_kolom_3' => $request->hasilnilai_kolom_3,
            'hasilnilai_kolom_4' => $request->hasilnilai_kolom_4,
            'hasilnilai_kolom_5' => $request->hasilnilai_kolom_5,
        ]);
        

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Memperbaharui Data Hasil Nilai Peserta Tes!', 
            'data'    => $data
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Memperbaharui Data Hasil Nilai Peserta Tes!', 
            'data'  => $data
        ], 'bad request');
    }

    #DELETE/POST
    public function delete(int $id) {
        $data = $this->service->delete($id);

        if($data > 0) return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Hasil Nilai Peserta Tes!', 
            'data'   => $data
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Menghapus Data Hasil Nilai Peserta Tes!', 
            'data'  => $data
        ], 'bad request');
    }
}
