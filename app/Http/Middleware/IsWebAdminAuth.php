<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class IsWebAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        if( isset($_COOKIE['_pas-g1']) &&
            isset($_COOKIE['_pas-m2']) &&
            isset($_COOKIE['_pas-t3']) &&
            isset($_COOKIE['_pas-sys']) &&
            isset($_COOKIE['_pas-kn']) &&
            isset($_COOKIE['_pas-nq']) &&
            isset($_COOKIE['XSRF-TOKEN'])
        ) {
            if($request->cookie('_pas-g1') == 1) {
                if($request->cookie('_pas-m2') == 1) {
                    if($request->cookie('_pas-t3') == 1) {
                        if($request->session()->has('id')) {
                            if($request->session()->has('nama')) {
                                if($request->session()->has('email')) {
                                    if($request->session()->has('roles')) {
                                        return $next($request);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            return redirect()->route('admin_logout');
        }
    }
}
