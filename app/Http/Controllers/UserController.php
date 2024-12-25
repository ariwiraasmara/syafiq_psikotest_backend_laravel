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
        // return $request;
        $data = $this->service->login($request->email, $request->password);

        if($data['success']) {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $path = '/';
                $domain = 'localhost';

                $user = Auth::user();
                $token = fun::encrypt($user->createToken($request->email)->accessToken);
                $response = new Response([
                    'pesan' => 'Yehaa! Berhasil Login!',
                    'success' => 1,
                    'nama' => $data['data'][0]['name'],
                    'token' => $token
                ]);

                $response->withCookie(cookie('islogin', true, 60));
                $response->withCookie(cookie('isadmin', true, 60));
                $response->withCookie(cookie('__sysel__', fun::encrypt(fun::enval($data['data'][0]['email'])), 60));
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
        fun::setCookieOff('islogin', true, $domain);
        fun::setCookieOff('isadmin', true, $domain);
        fun::setCookieOff('__sysel__', true, $domain);
        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Akhirnya Logout!'
        ], 'ok');
    }

    #GET
    public function dashboard() {
        if(Cache::has('page-dashboard')) $data = Cache::get('page-dashboard');
        else {
            Cache::put('page-dashboard', $this->service->dashboard(), 1*6*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-dashboard');
        };

        // membandingkan 2 data, data yang tersimpan di cache dan data terbaru
        $latestData = $this->service->dashboard();
        if(!$data->diff($latestData)) {
            Cache::put('page-dashboard', $latestData, 1*6*60*60); // 30 hari x 24 jam x 60 menit x 60 detik
            $data = Cache::get('page-dashboard');
        }

        return jsr::print([
            'success'   => 1,
            'pesan'     => 'Dashboard!',
            'data'      => $data
        ], 'ok');
    }
}
