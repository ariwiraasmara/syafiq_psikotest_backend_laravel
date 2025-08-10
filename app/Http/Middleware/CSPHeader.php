<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
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

		$urlReport = route('api_csp_report');
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'nonce-$nonce' https://cdn.jsdelivr.net https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "img-src 'self' data: https://images.pexels.com",
			"connect-src 'self'",
            "font-src 'self' https://fonts.gstatic.com",
            "object-src 'none'",
            "base-uri 'none'",
            "frame-ancestors 'none'",
            //"require-trusted-types-for 'script'",
            "form-action 'self'",
            "upgrade-insecure-requests",
            "report-uri $urlReport"
        ];
        $csp = implode('; ', $cspDirectives) . ';';
        //$response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('Content-Security-Policy-Report-Only', $csp); // Optional: untuk uji coba
        $response->headers->set('Report-To', json_encode([
            'group' => 'csp-endpoint',
            'max_age' => 10886400,
            'endpoints' => [
                ['url' => $urlReport]
            ],
        ]));

        return $response;
    }
}
