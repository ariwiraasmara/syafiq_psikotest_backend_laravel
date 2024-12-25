<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        if(Cache::has('page-psikotest_kecermatankolompertanyaan-all')) $data = Cache::get('page-psikotest_kecermatankolompertanyaan-all');
        else {
            Cache::put('page-psikotest_kecermatankolompertanyaan-all', $this->service->all(), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-psikotest_kecermatankolompertanyaan-all');
        }

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->all();
        if(!$data->diff($latestData)) {
            Cache::put('page-psikotest_kecermatankolompertanyaan-all', $latestData, 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-psikotest_kecermatankolompertanyaan-all');
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Soal Psikotest Kecermatan!',
            'data'      => $data
        ], 'ok');
    }

    #GET
    public function get(String|int $val) {
        if(Cache::has('page-psikotest_kecermatanakolompertanyaan-get-'.$val)) $data = Cache::get('page-psikotest_kecermatanakolompertanyaan-get-'.$val);
        else {
            Cache::put('page-psikotest_kecermatanakolompertanyaan-get-'.$val, $this->service->get($val), 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-psikotest_kecermatanakolompertanyaan-get-'.$val);
        }

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->get($val);
        if(!$data->diff($latestData)) {
            Cache::put('page-psikotest_kecermatanakolompertanyaan-get-'.$val, $latestData, 1*6*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-psikotest_kecermatanakolompertanyaan-get-'.$val);
        }

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
