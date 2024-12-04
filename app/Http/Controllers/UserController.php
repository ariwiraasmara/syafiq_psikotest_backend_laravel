<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use App\Repositories\userRepository;
use Illuminate\Http\Request;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    //
    protected userRepository $repo;
    public function __construct(userRepository $repo) {
        $this->repo = $repo;
    }

    #POST
    public function login(Request $request) {
        $where   = array('email' => $request->user);
        $cekUser = $this->repo->get($where);
            
        if( is_null($cekUser) ) {
            // return collect(['pesan' => 'Email Salah!', 'error' => 1]); //'Wrong Username / Email';
            return jsr::print([
                'pesan' => 'Email Salah!', 
                'error' => -1
            ], 'ok');
        }
        
        if (!Hash::check($request->pass, $cekUser[0]['password'])) { 
            // return collect(['pesan' => 'Password Salah! Silahkan Coba Lagi!', 'error' => 2]); //'Wrong Password!';
            return jsr::print([
                'pesan' => 'Password Salah!', 
                'error' => -2
            ], 'ok');
        }
        
        // if($data['success']) {
        if($cekUser) {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
     
                fun::setCookie([
                    'islogin'      => 1,
                    "mcr_x_aswq_1" => $cekUser[0]['id'],
                    "mcr_x_aswq_2" => $cekUser[0]['email'],
                ], true, 1, 24, 60, 60, '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev');
    
                return jsr::print([
                    'pesan' => 'Yehaa! Berhasil Login!', 
                    'success' => 1
                ], 'ok');
            }
        }
    }

    #GET
    public function logout() {
        $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        Auth::logout();
        fun::setCookieOff('islogin', true, $domain);
        fun::setCookieOff('mcr_x_aswq_1', true, $domain);
        fun::setCookieOff('mcr_x_aswq_2', true, $domain);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Akhirnya Logout!'
        ], 'ok');
    }

    #GET
    public function dashboard() {
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Dashboard!', 
            'data'      => $this->repo->get(['email' => fun::getCookie('mcr_x_aswq_2')])
        ], 'ok');
    }
}
