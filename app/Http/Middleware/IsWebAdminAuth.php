<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class IsWebAdminAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    
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
    **/
    public function handle(Request $request, Closure $next) {
        // Check if all required cookies are set
        if (isset($_COOKIE['_pas-g1']) &&
            isset($_COOKIE['_pas-m2']) &&
            isset($_COOKIE['_pas-t3']) &&
            isset($_COOKIE['_pas-sys']) &&
            isset($_COOKIE['_pas-kn']) &&
            isset($_COOKIE['_pas-nq']) &&
            isset($_COOKIE['XSRF-TOKEN'])
        ) {
            // Check if session has expired
            if ($this->sessionExpired($request)) {
                $this->clearSessionAndCookies($request);
                return redirect()->route('admin_logout');
            }
    
            // Check if all required session variables are present
            if ($request->cookie('_pas-g1') == 1 &&
                $request->cookie('_pas-m2') == 1 &&
                $request->cookie('_pas-t3') == 1 &&
                $request->session()->has('id') &&
                $request->session()->has('nama') &&
                $request->session()->has('email') &&
                $request->session()->has('roles')
            ) {
                return $next($request);
            }
        }
    
        return redirect()->route('admin_logout');
    }
    
    /**
     * Check if the session has expired.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function sessionExpired(Request $request) {
        // Implement your logic to check if the session has expired
        // For example, compare current time with a session expiry time
        return false; // Replace with actual logic
    }
    
    /**
     * Clear session and cookies.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function clearSessionAndCookies(Request $request) {
        $request->session()->flush(); // Clear all session data
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/'); // Expire the cookie
        }
    }
}
