<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(self), geolocation=(self)');

        $nonce = base64_encode(random_bytes(16));
        $urlApp = config('app.url');
        $urlAppAPI = $urlApp.'/api';
        $cspDirectives = [
            "default-src 'self'",
            // "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:8000",
            // "script-src 'self' 'nonce-{$nonce}' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:8000",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:8000",
            "style-src 'self' https://fonts.googleapis.com http://localhost:3000 http://localhost:8000",
            "img-src 'self' data: https://images.pexels.com http://localhost:3000 http://localhost:8000 https://trusted-images.com",
            "font-src 'self' https://fonts.gstatic.com",
            "connect-src 'self' http://localhost:3000 http://localhost:8000 $urlApp $urlAppAPI",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests",
            "report-uri /api/csp-report"
        ];
        $csp = implode('; ', $cspDirectives) . ';';
        // $response->headers->set('Content-Security-Policy', $csp);
        // $response->headers->set('Content-Security-Policy-Report-Only', $csp); // Optional: untuk uji coba
        $response->headers->set('Report-To', json_encode([
            'group' => 'csp-endpoint',
            'max_age' => 10886400,
            'endpoints' => [
                ['url' => url('/api/csp-report')]
            ],
        ]));

        return $response;
    }
}
