<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use App\Services\userService;
use Illuminate\Http\Request;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserController extends Controller {
    //
    protected userService $service;
    public function __construct(userService $service) {
        $this->service = $service;
    }

    #POST
    public function login(Request $request) {
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        // $domain = 'localhost';

        // return $request;
        $data = $this->service->login($request->email, $request->password);
            
        if($data['success']) {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                // $request->session()->regenerate();
                // return $data['data'];
                // fun::setCookie([
                //     'islogin'      => 1,
                //     "mcr_x_aswq_1" => $data['data'][0]['id'],
                //     "mcr_x_aswq_2" => $data['data'][0]['email'],
                // ], true, 1, 24, 60, 60, $domain);
    
                // return jsr::print([
                //     'pesan' => 'Yehaa! Berhasil Login!', 
                //     'success' => 1
                // ], 'ok');

                $response = new Response([
                    'pesan' => 'Yehaa! Berhasil Login!', 
                    'success' => 1
                ]);
                // self::encrypt(self::enval($val))
                // $response->withCookie(cookie('token', 'your_token_value', 60));
                $response->withCookie(cookie('islogin', fun::encrypt(fun::enval(1)), 60));
                $response->withCookie(cookie('email', fun::encrypt(fun::enval($data['data'][0]['email'])), 60));
                // $response->withCookie(cookie('mcr_x_aswq_2', fun::encrypt(fun::enval($data['data'][0]['email'])), 60));
                // return Auth::user();
                return $response;
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
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        $domain = 'localhost';
        Auth::logout();
        // fun::setCookieOff('token', true, $domain);
        fun::setCookieOff('islogin', true, $domain);
        fun::setCookieOff('email', true, $domain);
        // cookie(Hash::make('email'), null);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Akhirnya Logout!'
        ], 'ok');
    }

    #GET
    public function dashboard() {
        // return fun::getCookie('email');
        $data = $this->service->dashboard();
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Dashboard!', 
            'data'      => $data
        ], 'ok');
    }
}
