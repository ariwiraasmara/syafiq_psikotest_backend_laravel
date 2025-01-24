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
    public function index() {
        // $domain = '9002-idx-umkmku-1726831788791.cluster-a3grjzek65cxex762e4mwrzl46.cloudworkstations.dev';
        $domain = 'localhost';
        Auth::logout();
        fun::setCookieOff('islogin', true, $domain);
        fun::setCookieOff('isadmin', true, $domain);
        fun::setCookieOff('isauth', true, $domain);
        fun::setCookieOff('__sysel__', true, $domain);
        return Inertia::render('logout/page');
    }
}
