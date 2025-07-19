<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $default_src = `default-src 'self'; `;
        $script_src = `script-src 'self' http://localhost:8000 http://localhost:3000 https://trusted-scripts.com `;
        $style_src = `style-src 'self' 'unsafe-inline'; `;
        $img_src = `img-src 'self' http://localhost:8000 http://localhost:3000 https://trusted-images.com; `;
        $csp = $default_src . $script_src . $style_src . $img_src;

        // Menambahkan header CSP ke respons
        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
