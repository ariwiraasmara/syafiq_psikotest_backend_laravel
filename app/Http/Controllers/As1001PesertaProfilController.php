<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\as1001_peserta_profilRepository;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;

class As1001PesertaProfilController extends Controller {
    //
    protected as1001_peserta_profilRepository $repo;
    public function __construct(as1001_peserta_profilRepository $repo) {
        $this->repo = $repo;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!', 
            'data'      => $this->repo->all()
        ], 'ok'); 
    }

    #GET
    public function get(string $no_identitas) {
        $data = $this->repo->get(['no_identitas' => $no_identitas]);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Peserta\n'.$data[0]['nama'].' ('.$no_identitas.')', 
            'data'      => $data
        ], 'ok'); 
    }

    #POST
    public function store(Request $request) {
        $data = $this->repo->store([
            'nama'          => $request->nama,
            'no_identitas'  => $request->no_identitas,
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'usia'          => $request->usia,
            'asal'          => $request->asal,
            'tgl_ujian'     => $request->tgl_ujian,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menyimpan Data Peserta Tes!', 
            'data'      => $data
        ], 'created'); 
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        $data = $this->repo->update($id, [
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'usia'          => $request->usia,
            'asal'          => $request->asal,
            'tgl_ujian'     => $request->tgl_ujian,
        ]);

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Memperbaharui Data Peserta Tes!', 
            'data'      => $data
        ], 'ok'); 
    }

    #POST/DELETE
    public function delete(int $id) {
        $data = $this->repo->delete($id);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Berhasil Menghapus Data Peserta Tes!', 
        ], 'ok'); 
    }

}
