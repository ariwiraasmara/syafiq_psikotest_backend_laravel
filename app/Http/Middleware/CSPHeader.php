<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CSPHeader {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        $urlApp = config('app.url');
        $urlAppAPI = $urlApp.'/api';
        $cspDirectives = [
            "default-src 'self'",
            // "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:8000",
            // "script-src 'self' 'nonce-{$nonce}' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:8000",
            "script-src 'self' 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https: https://cdn.jsdelivr.net https://unpkg.com http://localhost:3000 http://localhost:4000 http://localhost:8000",
            "style-src 'self' https://fonts.googleapis.com http://localhost:3000 http://localhost:4000 http://localhost:8000",
            "img-src 'self' data: https://images.pexels.com http://localhost:3000 http://localhost:4000 http://localhost:8000 https://trusted-images.com",
            "font-src 'self' https://fonts.gstatic.com",
            "connect-src 'self' http://localhost:3000 http://localhost:4000 http://localhost:8000 $urlApp $urlAppAPI",
            "object-src 'none'",
            "base-uri 'none'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "require-trusted-types-for 'script'",
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
