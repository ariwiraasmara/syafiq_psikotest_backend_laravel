<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHTML
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $output = $response->getContent();

            // Hapus komentar HTML kecuali conditional IE
            $output = preg_replace('/<!--(?!\[if).*?-->/', '', $output);

            // Hapus whitespace berlebihan
            $output = preg_replace('/\s{2,}/', ' ', $output);

            $response->setContent($output);
        }

        return $response;
    }
}
