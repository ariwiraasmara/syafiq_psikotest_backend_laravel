<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\as1001_peserta_profilService;
use App\Libraries\myfunction as fun;
use App\Libraries\jsr;
class As1001PesertaProfilController extends Controller {
    //
    protected as1001_peserta_profilService $service;
    public function __construct(as1001_peserta_profilService $service) {
        $this->service = $service;
    }

    #GET
    public function generate_token_first(Request $request) {
        $response = new Response([
            'success' => 1,
            'pesan' => 'Generate Token Untuk Peserta Ujian Berhasil!'
        ]);
        $expirein = 6 * 60; // jam * menit
        $response->withCookie(cookie('csrf-token', csrf_token(), $expirein));
        $response->withCookie(cookie('__token__', fun::encrypt(fun::enval(fun::random('combwisp'))), $expirein));
        $response->withCookie(cookie('__unique__', fun::enval(fun::random('combwisp')), $expirein));

        return $response;
    }

    #GET
    public function all() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!',
            'data'      => $this->service->allProfil()
        ], 'ok');
    }

    public function allLatest() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!',
            'data'      => $this->service->allLatest()
        ], 'ok');
    }

    #GET
    public function get(string $id) {
        $data = $this->service->get($id);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Peserta '.$data[0]['nama'].' ('.$data[0]['no_identitas'].')',
            'data'      => $data
        ], 'ok');
    }

    #POST
    public function store(Request $request) {
        // return $request;
        $data = $this->service->store([
            'nama'          => $request->nama,
            'no_identitas'  => $request->no_identitas,
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'asal'          => $request->asal,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Menyimpan Data Peserta Tes!',
            // $data
        ], 'created');

        return jsr::print($data->toArray(), 'bad request');
    }

    #PUT/POST
    public function update(Request $request, int $id) {
        $data = $this->service->update($id, [
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'asal'          => $request->asal,
        ]);

        if($data > 0) return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Memperbaharui Data Peserta Tes!',
            // 'data'    => $data
        ], 'ok');

        return jsr::print($data->toArray(), 'bad request');
    }

    #POST
    public function setUpPesertaTes(Request $request) {
        // return $request->no_identitas;
        $data = $this->service->setUpPesertaTes([
            'nama'          => $request->nama,
            'no_identitas'  => $request->no_identitas,
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'asal'          => $request->asal,
        ]);

        if($data['res'] > 0 || $data != 'err2') return jsr::print([
            'success' => 1,
            'pesan'   => 'Berhasil Setup Data Peserta Tes!',
            'data'    => $data
        ], 'ok');

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Setup Data Peserta Tes!',
            'data'  => $data
        ], 'bad request');
    }

    #DELETE/POST
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
