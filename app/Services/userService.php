<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\userRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Libraries\myfunction as fun;
class userService {

    protected userRepository $repo;
    public function __construct(userRepository $repo) {
        $this->repo = $repo;
    }

    public function login(String $email, String $pass) {
        try {
            $where   = array('email' => $email);
            $cekUser = $this->repo->get($where);
            if( is_null($cekUser) ) {
                return collect(['pesan' => 'Email Salah!', 'error' => 1]); //'Wrong Username / Email';
            }
            if (!Hash::check($pass, $cekUser[0]['password'])) {
                return collect(['pesan' => 'Password Salah! Silahkan Coba Lagi!', 'error' => 2]); //'Wrong Password!';
            }
            return collect([
                'success'   => 1,
                'pesan'     => 'Yehaa! Berhasil Login!',
                'data'      => $cekUser
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

    public function updateRemembertoken(int $id, String $token): String {
        try {
            $res = $this->repo->update($id, ['remember_token' => $token]);
            if($res > 0) return $$token;
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

    public function dashboard(String $email): array|Collection|String|int|null {
        try {
            if(fun::getRawCookie('__sysel__')) {
                Log::channel('debugging')->debug('ambil data dari cookie!', [
                    'email' => fun::getCookie('__sysel__')
                ]);
                return $this->repo->get(['email' => fun::getCookie('__sysel__')]);
            }
            Log::channel('debugging')->debug('ambil data dari request parameter!', [
                'email' => $email
            ]);
            return $this->repo->get(['email' => $email]);
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
}
?>