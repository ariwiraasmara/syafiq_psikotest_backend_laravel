<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(self), geolocation=(self)');

        // Jika bukan HTTPS, redirect ke versi HTTPS
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }
        $expiry_StrictTransportSecurity = 60 * 60 * 24 * 365 * 100; // 100 year in seconds
        $response->headers->set('Strict-Transport-Security', "max-age=$expiry_StrictTransportSecurity; includeSubDomains; preload");

        return $response;
    }
}
