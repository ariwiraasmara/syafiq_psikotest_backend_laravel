<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CheckTokenLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        if($request->hasHeader('tokenlogin')) {
            if(!$request->header()['tokenlogin']) return response()->json(['message' => 'Token Login Not Found!'], 404);
            return $next($request);
        }
        return response()->json(['message' => 'Token Login Not Found!'], 404);
    }
}
