<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use App\Services\userService;
use Illuminate\Http\Request;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller {
    //
    protected userService $service;
    public function __construct(userService $service) {
        $this->service = $service;
    }

    #POST
    public function login(Request $request) {
        $data = $this->service->login($request->email, $request->password);
            
        if($data['success']) {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
     
                fun::setCookie([
                    'islogin'      => 1,
                    "mcr_x_aswq_1" => $data['data'][0]['id'],
                    "mcr_x_aswq_2" => $data['data'][0]['email'],
                ], true, 1, 24, 60, 60, '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev');
    
                return jsr::print([
                    'pesan' => 'Yehaa! Berhasil Login!', 
                    'success' => 1
                ], 'ok');
            }
        }

        return match($data->get('error')){
            1 => jsr::print([
                'pesan' => 'Username / Email Salah!', 
                'error'=> 1], 'bad request'),
            2 => jsr::print([
                'pesan' => 'Password Salah!', 
                'error'=> 2],'bad request'),
            default => jsr::print([
                'pesan' => 'Terjadi Kesalahan!', 
                'error'=> -1])            
        };
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
            'data'      => $this->service->dashboard()
        ], 'ok');
    }
}
