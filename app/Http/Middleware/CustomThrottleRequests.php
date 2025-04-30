<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;


class CustomThrottleRequests extends ThrottleRequests {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected function buildResponse($key, $maxAttempts)
    {
        $response = new Response('Anda telah melampaui jumlah permintaan maksimum. Silakan coba lagi nanti.', 429);

        // Optionally, you can add headers or customize the response further
        $response->headers->set('Retry-After', $this->getTimeUntilNextRetry($key));

        return $response;
    }
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
}
