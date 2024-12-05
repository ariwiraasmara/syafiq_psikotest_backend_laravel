<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\as1001_peserta_profilService;
use App\Libraries\jsr;
class As1001PesertaProfilController extends Controller {
    //
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!', 
            'data'      => $this->service->allProfil()
        ], 'ok'); 
    }

    #GET
    public function get(string $no_identitas) {
        $data = $this->service->get($no_identitas);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Peserta\n'.$data[0]['nama'].' ('.$no_identitas.')', 
            'data'      => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request) {
        $data = $this->service->store([
            'nama'          => $request->nama,
            'no_identitas'  => $request->no_identitas,
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'usia'          => $request->usia,
            'asal'          => $request->asal,
            'tgl_ujian'     => $request->tgl_ujian,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menyimpan Data Peserta Tes!', 
            'data'    => $data
        ], 'created'); 

        return jsr::print([
            'error'   => 1,
            'pesan'   => 'Gagal Menyimpan Data Peserta Tes!', 
        ], 'bad request'); 
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        $data = $this->service->update($id, [
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'usia'          => $request->usia,
            'asal'          => $request->asal,
            'tgl_ujian'     => $request->tgl_ujian,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Memperbaharui Data Peserta Tes!', 
            'data'    => $data
        ], 'ok'); 
    
        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Memperbaharui Data Peserta Tes!', 
            'data'  => $data
        ], 'bad request'); 
    }

    #POST/DELETE
    public function delete(int $id) {
        $data = $this->service->delete($id);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menghapus Data Peserta Tes!', 
            'data'    => $data
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Menghapus Data Peserta Tes!', 
            'data'  => $data
        ], 'bad request'); 
    }

}
