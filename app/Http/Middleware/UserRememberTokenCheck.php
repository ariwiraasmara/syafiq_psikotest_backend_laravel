<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Middleware;

use Closure;
Use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;
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
                $remember_token = fun::denval($request->header()['remember-token'][0], true);
                $cek = User::where(['remember_token' => $remember_token])->first();
                if (!$cek) return response()->json(['message' => 'I cannot remember your token. '.$request->header()['remember-token'][0]], 404);
                return $next($request);
            }
            return response()->json(['message' => 'Where is your Token!'], 404);
        }
        return response()->json(['message' => 'Unauthorized!'], 404);
    }
}
