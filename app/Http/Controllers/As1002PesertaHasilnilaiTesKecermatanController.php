<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Libraries\jsr;
class As1002PesertaHasilnilaiTesKecermatanController extends Controller {
    //
    protected as1002_peserta_hasilnilai_teskecermatanService $service;
    public function __construct(as1002_peserta_hasilnilai_teskecermatanService $service) {
        $this->service = $service;
    }

    #GET
    public function all($id) {
        if(Cache::has('page-pesertahasilnilaipsikotestkecermatan-all-'.$id)) $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
        else {
            Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $this->service->all($id), 1*24*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
        }

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->all($id);
        if(!$data->diff($latestData)) {
            Cache::put('page-pesertahasilnilaipsikotestkecermatan-all-'.$id, $latestData, 1*24*60*60); // 1 hari x 6 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-all-'.$id);
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Semua Data Hasil Nilai Peserta Ujian!',
            'data'      => $data
        ], 'ok');
    }

    #GET
    public function get(int $id, String $tgl) {
        // $data = $this->service->get($id, $tgl);
        if(Cache::has('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl)) $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl);
        else {
            Cache::put('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl, $this->service->get($id, $tgl), 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl);
        }

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->get($id, $tgl);
        if(!$data->diff($latestData)) {
            Cache::put('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl, $latestData, 1*3*60*60); // 1 hari x 3 jam x 60 menit x 60 detik
            $data = Cache::get('page-pesertahasilnilaipsikotestkecermatan-get-'.$id.'-'.$tgl);
        }

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
