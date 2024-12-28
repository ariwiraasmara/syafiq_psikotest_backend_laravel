<?php
//! Copyright @ 
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
Use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class MatchingUserData {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if($request->hasHeader('islogin') && $request->hasHeader('isadmin')) {
            if($request->hasHeader('email')) {
                $cek = User::where(['email' => $request->header()['email']])->first();
                if (!$cek) return response()->json(['message' => 'Email not found in database.'], 404);
                if(![$cek][0]->email_verified_at || is_null([$cek][0]->email_verified_at)) return response()->json(['message' => 'Email not verified.'], 404);
                return $next($request);
            }
            return response()->json(['message' => 'Email at Header Not Found!'], 404);
        }
        return response()->json(['message' => 'Unauthorized!'], 404);
    }
}