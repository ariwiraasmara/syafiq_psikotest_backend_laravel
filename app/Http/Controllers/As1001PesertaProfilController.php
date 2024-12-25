<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
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
        if(Cache::has('page-pesertaprofil-all')) $data = Cache::get('page-pesertaprofil-all');
        else {
            Cache::put('page-pesertaprofil-all', $this->service->allProfil(), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-all');
        }

        $latestData = $this->service->allLatest();
        if(!$data->diff($latestData)) {
            Cache::put('page-pesertaprofil-all', $latestData, 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-all');
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!',
            'data'      => $data
        ], 'ok');
    }

    public function allLatest() {
        if(Cache::has('page-pesertaprofil-allLatest')) $data = Cache::get('page-pesertaprofil-allLatest');
        else {
            Cache::put('page-pesertaprofil-allLatest', $this->service->allLatest(), 1*6*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-allLatest');
        }

        $latestData = $this->service->allLatest();
        if(!$data->diff($latestData)) {
            Cache::put('page-pesertaprofil-allLatest', $latestData, 1*6*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-allLatest');
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Peserta Tes!',
            'data'      => $data
        ], 'ok');
    }

    #GET
    public function get(string $id) {
        if(Cache::has('page-pesertaprofil-get-'.$id)) $data = Cache::get('page-pesertaprofil-get-'.$id);
        else {
            Cache::put('page-pesertaprofil-get-'.$id, $this->service->get($id), 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-get-'.$id);
        };

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->get($id);
        if(!$data->diff($latestData)) {
            Cache::put('page-pesertaprofil-get-'.$id, $latestData, 30*24*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertaprofil-get-'.$id);
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Data Detil Peserta',
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

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Memperbaharui Data Peserta Tes!',
        ], 'bad request');
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

        return jsr::print([
            'error' => 1,
            'pesan' => 'Gagal Memperbaharui Data Peserta Tes!',
        ], 'bad request');
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
        // return $data;

        if($data['success']) {
            $data->put('success', 1);
            $data->put('pesan', 'Berhasil Setup Data Peserta Tes!');
            return $data->toJSON();
        };

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
