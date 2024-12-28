<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CSRF_Check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Mengecek apakah ada token CSRF pada header 'X-CSRF-TOKEN'
        // $csrfToken = $request->header('X-CSRF-TOKEN');
        $csrfToken = $request->header('XSRF-TOKEN');

        // Memeriksa apakah token CSRF valid dengan token yang ada di session
        if (!$csrfToken || $csrfToken !== Session::token()) {
            // Jika token tidak valid, bisa mengembalikan response error atau melog
            return response()->json(['message' => 'Cross Attack!'], 404);
        }

        // Jika token valid, lanjutkan request ke langkah berikutnya
        return $next($request);
        
    }
}
