<?php
//! Copyright @ 
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
Use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Libraries\myfunction as fun;
class MatchingUserData {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $cek = User::where(['email' => fun::getCookie('email')])->first();
        if (!$cek) return response()->json(['message' => 'Email not found in database.'], 404);
        // if (!Hash::check($request->password, $cek[0]['password'])) return response()->json(['message' => 'Password is not match!'], 404);
        // if ( $cek[0]['remember_token'] == null ) return response()->json(['message' => 'Token not exist!.'], 404);
        // if ($cek->get('token') != $request->token) return response()->json(['message' => 'Input Token invalid!.'], 404);

        return $next($request);
    }
}