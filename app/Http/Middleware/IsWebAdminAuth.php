<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
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
        if( isset($_COOKIE['islogin']) &&
            isset($_COOKIE['isadmin']) &&
            isset($_COOKIE['isauth']) &&
            isset($_COOKIE['__sysauth__']) &&
            isset($_COOKIE['__token__']) &&
            isset($_COOKIE['__unique__']) &&
            isset($_COOKIE['XSRF-TOKEN'])
        ) {
            if($request->cookie('islogin') == 1) {
                if($request->cookie('isadmin') == 1) {
                    if($request->cookie('isauth') == 1) {
                        return $next($request);
                    }
                }
            }
        }
        else {
            return redirect()->route('admin_logout');
        }
    }
}
