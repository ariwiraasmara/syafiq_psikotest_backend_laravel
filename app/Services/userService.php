<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Services;

use App\Repositories\userRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Libraries\myfunction as fun;
class userService {

    protected userRepository $repo;
    public function __construct(userRepository $repo) {
        $this->repo = $repo;
    }

    public function login(String $email, String $pass) {
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

    public function dashboard() {
        return $this->repo->get(['email' => fun::getCookie('email')]);
    }

}
?>