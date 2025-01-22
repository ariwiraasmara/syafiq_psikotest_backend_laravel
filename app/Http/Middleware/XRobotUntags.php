<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XRobotUntags
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        // Menambahkan header X-Robots-Tag ke semua respon
        $response->headers->set('X-Robots-Tag', 'none, nosnippet, noarchive, notranslate, noimageindex');
        return $response;
    }
}
