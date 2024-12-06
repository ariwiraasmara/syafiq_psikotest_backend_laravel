<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\as2002_kecermatan_soalService;
use App\Libraries\jsr;
class As2002KecermatanSoaljawabanController extends Controller {
    //
    protected as2002_kecermatan_soalService $service;
    public function __construct(as2002_kecermatan_soalService $service
    ) {
        $this->service = $service;
    }

    #GET
    public function json(int $id) {
        $data = $this->service->json($id);
        return $data;
    }

    #GET
    public function allRaw(int $id) {
        $data = $this->service->all($id);
        return $data;
        return jsr::print([
            'success' => 1,
            'pesan'   => 'Semua Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan '.$data['pertanyaan'][0]['kolom_x'], 
            'data'    => $data,
        ], 'ok'); 
    }

    #GET
    public function allCooked(String|int $kolom) {
        $data = $this->service->get($kolom);
        return jsr::print([
            'success' => 1,
            'pesan'   => 'Data Pertanyaan, Soal dan Jawaban Psikotest Kecermatan : '.$data['pertanyaan'][0]['kolom_x'], 
            'data'    => $data,
        ], 'ok'); 
    }

    #POST
    public function store(Request $request, int $id) {
        $data = $this->service->store($id, [
            'id2001'        => $id,
            'soal_jawaban'  => $request->soal_jawaban,
        ]);

        if($data->isNotEmpty()) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
            'data'    => $data['data']
        ], 'created');

        return jsr::print([
            'error'   => 1,
            'pesan'   => 'Gagal Menyimpan Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
        ], 'bad request');
    }

    #PUT/POST
    public function update(Request $request, int $id1, int $id2) {
        $data = $this->service->update($id1, $id2, [
            'soal_jawaban' => $request->soal_jawaban,
        ]);

        if($data->isNotEmpty()) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
            'data'    => $data['data']
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Memperbaharui Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
            'data'  => $data['data']
        ], 'bad request');
    }

    #DELETE/POST
    public function delete(int $id1, int $id2) {
        $data = $this->service->delete($id1, $id2);
        
        if($data->isNotEmpty()) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
            'data'    => $data['data']
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Menghapus Data Soal dan Jawaban Psikotest Kecermatan '.$data['kolom_x'], 
            'data'  => $data['data']
        ], 'bad request');
    }
}
