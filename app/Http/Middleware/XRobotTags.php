<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XRobotTags
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
        $response->headers->set('X-Robots-Tag', 'index, follow, snippet, max-snippet:99, noarchive, notranslate');


        return $response;
    }
}
