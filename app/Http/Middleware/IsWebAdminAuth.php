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
    public function handle(Request $request, Closure $next): Response {
        if( $request->cookie('islogin') &&
            $request->cookie('isadmin') &&
            $request->cookie('isauth') &&
            $request->cookie('__sysauth__') &&
            $request->cookie('__token__') &&
            $request->cookie('__unique__') &&
            $request->cookie('XSRF-TOKEN')
        ) {
            return $next($request);
        }
        else {
            return redirect()->route('admin_logout');
        }
    }
}
