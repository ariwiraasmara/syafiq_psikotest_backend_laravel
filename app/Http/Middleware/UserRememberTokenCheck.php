<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
Use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Libraries\myfunction as fun;
class UserRememberTokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if($request->hasHeader('islogin') && $request->hasHeader('isadmin')) {
            if($request->hasHeader('remember-token')) {
                $remember_token = $request->header()['remember-token'][0];
                $cek = User::where(['remember_token' => $remember_token])->first();
                if (!$cek) return response()->json(['message' => 'I cannot remember your token. '.$request->header()['remember-token'][0]], 404);
                return $next($request);
            }
            return response()->json(['message' => 'Where is your Token!'], 404);
        }
        return response()->json(['message' => 'Unauthorized!'], 404);
    }
}
