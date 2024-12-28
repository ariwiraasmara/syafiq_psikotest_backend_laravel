<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequest {
    public function handle(Request $request, Closure $next): Response {
        // Mencatat informasi request menggunakan Log::info pada channel custom_log
        Log::channel('header-request')->info('Request Information:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'params' => $request->all(),
        ]);

        // Melanjutkan request ke middleware berikutnya
        $response = $next($request);

        // Mencatat informasi response menggunakan Log::notice pada channel custom_log
        Log::channel('header-request')->notice('Response Information:', [
            'status' => $response->status(),
            'content' => $response->getContent(),
        ]);

        return $response;
    }
}
