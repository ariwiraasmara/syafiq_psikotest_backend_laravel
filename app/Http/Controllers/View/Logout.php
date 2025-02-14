<?php
// 
// 
// 
namespace App\Http\Controllers\View;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller {
    //
    public function index(Request $request) {
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        $domain = 'localhost';
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        fun::setCookieOff('islogin', true, $domain);
        fun::setCookieOff('isadmin', true, $domain);
        fun::setCookieOff('isauth', true, $domain);
        fun::setCookieOff('email', true, $domain);
        fun::setCookieOff('nama', true, $domain);
        fun::setCookieOff('pat', true, $domain);
        fun::setCookieOff('rtk', true, $domain);
        fun::setCookieOff('__sysel__', true, $domain);
        return Inertia::render('logout/page');
    }
}
