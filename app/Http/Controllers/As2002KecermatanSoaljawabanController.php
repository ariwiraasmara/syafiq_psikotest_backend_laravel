<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Repositories\as2002_kecermatan_soaljawabanRepository;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;

class As2002KecermatanSoaljawabanController extends Controller {
    //
    protected as2001_kecermatan_kolompertanyaanRepository $repo1;
    protected as2002_kecermatan_soaljawabanRepository $repo2;
    public function __construct(
        as2001_kecermatan_kolompertanyaanRepository $repo1,
        as2002_kecermatan_soaljawabanRepository $repo2
    ) {
        $this->repo1 = $repo1;
        $this->repo2 = $repo2;
    }

    #GET
    public function all(int $id) {
        $data = $this->repo1->get($id);
        return jsr::print([
            'success'       => 1,
            'pesan'         => 'Semua Data Soal dan Jawaban Psikotest Kecermatan '.$data[0]['kolom_x'], 
            'data_soal'     => $data,
            'data_jawaban'  => $this->repo2->all($id)
        ], 'ok'); 
    }

    #GET
    public function get(String $kolom, int $id) {
        $data_soal    = $this->repo1->get($kolom);
        $data_jawaban = $this->repo2->get($id);
        return jsr::print([
            'success'       => 1,
            'pesan'         => 'Data Soal dan Jawaban Psikotest Kecermatan : '.$data_soal[0]['kolom_x'].' Nomor '.$data_jawaban[0]['id'], 
            'data_soal'     => $data_soal,
            'data_jawaban'  => $data_jawaban,
        ], 'ok'); 
    }

    #POST
    public function store(Request $request, int $id) {
        $data1 = $this->repo1->get($id);
        $data2 = $this->repo2->store([
            'id2001'     => $id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data1[0]['kolom_x'], 
            'data'      => $data2
        ], 'created'); 
    }

    #PUT/POST
    public function update(Request $request, int $id1, int $id2) {
        $data1 = $this->repo1->get($id1);
        $data2 = $this->repo2->update($id2, [
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
            'updated_at' => $request->updated_at,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data1[0]['kolom_x'], 
            'data'      => $data2
        ], 'ok'); 
    }

    #DELETE/POST
    public function delete(int $id1, int $id2) {
        $data1 = $this->repo1->get($id1);
        $data2 = $this->repo2->delete($id2);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data1[0]['kolom_x'], 
        ], 'ok'); 
    }
}
