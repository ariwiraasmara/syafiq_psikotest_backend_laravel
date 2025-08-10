<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CacheControlMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        $time = 6 * 60 * 60;
        // Hanya cache file statis (CSS, JS, gambar)
        if ($request->is('assets/*') || $request->is('images/*') || $request->is('css/*') || $request->is('js/*')) {
            $response->headers->set('Cache-Control', "public, max-age={$time}, immutable");
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + $time));
        }
        else {
            // $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Cache-Control', 'public');
        }
        return $response;
    }
}
