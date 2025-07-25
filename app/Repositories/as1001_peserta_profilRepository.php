<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Repositories;

use App\Models\as1001_peserta_profil;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
class as1001_peserta_profilRepository {

    protected as1001_peserta_profil|null $model;
    public function __construct(as1001_peserta_profil $model) {
        $this->model = $model;
    }

    public function all(String $sort = 'nama', String $by = 'asc', String $search = null): array|Collection|String|int|null {
        try {
            if($this->model->first()) {
                if($search == 'null' || $search == '-' || $search == '' || $search == ' ' || $search == null || empty($search) || is_null($search)) {
                    return $this->model->select('id', 'nama', 'no_identitas', 'email', 'asal')
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
                else {
                    return $this->model->select('id', 'nama', 'no_identitas', 'email', 'asal')
                            ->where($sort, 'LIKE',"%{$search}%")
                            // ->orWhere('no_identitas', $search)
                            // ->orWhere('asal','LIKE',"%{$search}%")
                            ->orderBy($sort, $by)
                            ->limit(10)
                            ->paginate(10)
                            ->toArray();
                }
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function allLatest(): array|Collection|String|int|null {
        try {
            if($this->model->join('as1002_peserta_hasilnilai_teskecermatan', 'as1002_peserta_hasilnilai_teskecermatan.id1001', '=', 'as1001_peserta_profil.id')
                            ->first()) {
                return $this->model->distinct()
                                ->select('as1001_peserta_profil.id', 'nama', 'no_identitas', 'email', 'asal', 'as1002_peserta_hasilnilai_teskecermatan.tgl_ujian')
                                ->join('as1002_peserta_hasilnilai_teskecermatan', 'as1002_peserta_hasilnilai_teskecermatan.id1001', '=', 'as1001_peserta_profil.id')
                                ->orderBy('as1002_peserta_hasilnilai_teskecermatan.tgl_ujian', 'desc')
                                ->limit(10)
                                ->get();
            }
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->allLatest!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function allReport_forSitemap(): array|Collection|String|int|null {
        try {
            return $this->model->select('as1001_peserta_profil.id', 'as1001_peserta_profil.nama', 'as1001_peserta_profil.no_identitas', 'as1002_peserta_hasilnilai_teskecermatan.tgl_ujian')
                        ->join('as1002_peserta_hasilnilai_teskecermatan', 'as1002_peserta_hasilnilai_teskecermatan.id1001', '=', 'as1001_peserta_profil.id')
                        ->orderBy('as1001_peserta_profil.no_identitas', 'asc')
                        ->orderBy('as1002_peserta_hasilnilai_teskecermatan.tgl_ujian', 'desc')
                        ->get();
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->allReport!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function get(array $where): array|Collection|String|int|null {
        try {
            if($this->model->where($where)->first()) return $this->model->where($where)->get();
            return null;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function store(array $values): array|Collection|String|int|null {
        try {
            $res = $this->model->create($values);
            if($res->id > 0) return $res->id;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function update(int $id, array $values) {
        try {
            $res = $this->model->where(['id' => $id])->update($values);;
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->update!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function delete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->model->where(['id' => $id])->delete();;
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-repositories')->error('Terjadi kesalahan pada as1001_peserta_profilRepository->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -11;
        }
    }

    public function __destruct() {
        $this->model = null;
    }
}