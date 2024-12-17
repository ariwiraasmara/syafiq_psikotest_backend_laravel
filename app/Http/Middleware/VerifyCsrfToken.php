<?php
// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (AR)
namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

// class VerifyCsrfToken  {
class VerifyCsrfToken extends Middleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next

    // public function handle(Request $request, Closure $next): Response {
    //     return $next($request);
    // }
    */
    protected $except = [
        //
        '*',
    ];
}
