<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\userRepository;
use App\Repositories\personalaccesstokensRepository;
use App\Repositories\userdevicehistoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Libraries\myfunction as fun;
use Exception;

use function PHPUnit\Framework\returnSelf;

class userService {

    protected userRepository|null $repo1;
    protected personalaccesstokensRepository|null $repo2;
    protected userdevicehistoryRepository|null $repo3;
    public function __construct(
        userRepository $repo1,
        personalaccesstokensRepository $repo2,
        userdevicehistoryRepository $repo3
    ) {
        $this->repo1 = $repo1;
        $this->repo2 = $repo2;
        $this->repo3 = $repo3;
    }

    public function all() {
        try {
            return $this->repo1->all();
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function allWithSearch(String $sort, String $by, String $search = null): array|Collection|String|int|null {
        try {
            return $this->repo1->allWithSearch($sort, $by, $search);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->all!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function get($id): array|Collection|String|int|null {
        try {
            return $this->repo1->get(['id' => $id]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function profil(int $id): array|Collection|String|int|null {
        try {
            return $this->repo1->detail('id', $id);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function detail(String $type, $val): array|Collection|String|int|null {
        try {
            $user = $this->repo1->detail($type, $val);
            $pat = $this->repo2->get(['name' => $val]);
            $device_history = $this->repo3->get(['id_user' => $user[0]['id']]);
            return collect([
                'user' => $user,
                'pat'  => $pat,
                'device_history' => $device_history
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->get!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function store(array $val): array|Collection|String|int|null {
        try {
            $valAccount = [
                'name'           => $val['name'],
                'email'          => $val['email'],
                'password'       => Hash::make('Psi0@'),
                'roles'          => $val['roles'],
                'remember_token' => fun::random('combwisp', 10),
                'created_at'     => date('Y-m-d H:i:s'),
            ];

            $res1 = $this->repo1->storeAccount($valAccount);
            if($res1 > 0) {
                $valProfile = [
                    'id'           => $res1,
                    'no_identitas' => $val['no_identitas'],
                    'jk'           => $val['jk'],
                    'alamat'       => $val['alamat'],
                    'status'       => $val['status'],
                    'agama'        => $val['agama'],
                ];
                $res2 = $this->repo1->storeProfil($valProfile);
                if($res2 > 0) {
                    $abilities = '["*"]';
                    if($val['roles'] > 1) {
                        $abilities = '["admin.peserta" => ["read"],"admin.blog" => "*"]';
                    }

                    $valPAT = [
                        'id'            => $res1,
                        'tokenable_type'=> 'App\Models\User',
                        'tokenable_id'  => $res1,
                        'name'          => $val['email'],
                        'token'         => fun::random('combwisp', 64),
                        'abilities'     => $abilities,
                        'expires_at'    => fun::daysLater('+7 days'),
                        'created_at'    => date('Y-m-d H:i:s')
                    ];

                    $res3 = $this->repo2->store($valPAT);
                    if($res3 > 0) {
                        Storage::disk('user_admin')->makeDirectory($res1.'.'.$val['email']);
                        return $res3;
                    }
                    return $res2.' & -2';
                }
                return $res1.' & -1';
            }
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->store!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updateAccount(int $id, array $val): array|Collection|String|int|null {
        try {
            $res = $this->repo1->updateAccount($id, [
                'roles'      => $val['roles'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updateAccount!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updatePassword(int $id, String $password): array|Collection|String|int|null {
        try {
            $res = $this->repo1->updateAccount($id, [
                'password'   => Hash::make($password),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updatePassword!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updateRemembertoken(int $id): String {
        try {
            $token = Str::random(100);
            $res = $this->repo1->updateAccount($id, [
                'remember_token' => $token,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $token;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updateRemembertoken!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updatePAT($email): String {
        try {
            $token = Str::random(64);
            $res = $this->repo2->update($email, [
                'token'      => $token,
                'expires_at' => fun::daysLater('+7 days'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($res > 0) return $token;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updatePAT!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updateProfil(int $id, array $val): array|Collection|String|int|null {
        try {
            $res1 = $this->repo1->updateProfil($id, [
                'no_identitas' => $val['no_identitas'],
                'jk'           => $val['jk'],
                'alamat'       => $val['alamat'],
                'status'       => $val['status'],
                'agama'        => $val['agama'],
            ]);

            $res2 = $this->repo1->updateAccount($id, [
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return $res2;
            if($res2 > 0) return $res2;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updateProfil!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function updateFoto(int $id, array $val): array|Collection|String|int|null {
        try {
            $res1 = $this->repo1->updateAccount($id, [
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $res2 = $this->repo1->updateProfil($id, [
                'foto' => $val['foto'],
            ]);
            if(($res1 > 0) && ($res2 > 0)) return $res1;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->updateFoto!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function softDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo1->softDelete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function hardDelete(int $id): array|Collection|String|int|null {
        try {
            $res = $this->repo1->hardDelete($id);
            if($res > 0) return $res;
            return 0;
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->delete!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function login(array $val) {
        try {
            $where   = array('email' => $val['email']);
            $cekUser = $this->repo1->get($where);
            if( is_null($cekUser) ) {
                return collect(['pesan' => 'Email Salah!', 'error' => 1]); //'Wrong Username / Email';
            }
            if (!Hash::check($val['pass'], $cekUser[0]['password'])) {
                return collect(['pesan' => 'Password Salah! Silahkan Coba Lagi!', 'error' => 2]); //'Wrong Password!';
            }

            $this->repo3->store([
                'id_user'    => $cekUser[0]['id'],
                'ip_address' => $val['ip_address'],
                'user_agent' => $val['user_agent'],
                'last_login' => date('Y-m-d H:i:s'),
            ]);

            return collect([
                'success'   => 1,
                'pesan'     => 'Yehaa! Berhasil Login!',
                'data'      => $cekUser,
                'login_at'  => $val['login_at']
            ]);
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->login!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function dashboard(String $email): array|Collection|String|int|null {
        try {
            if(fun::getRawCookie('email')) {
                return $this->repo1->get(['email' => fun::getRawCookie('email')]);
            }
            else {
                Log::channel('debugging')->debug('ambil data dari request parameter!', [
                    'email' => $email
                ]);
                return $this->repo1->get(['email' => $email]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-services')->error('Terjadi kesalahan pada userService->dashboard!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return -12;
        }
    }

    public function __destruct() {
        $this->repo1 = null;
    }
}