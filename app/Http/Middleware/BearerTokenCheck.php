<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;
use App\Libraries\myfunction as fun;
use App\Services\personalaccesstokensService;
class BearerTokenCheck {
    /**
     * Handle an incoming request.
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if($request->hasHeader('islogin') && $request->hasHeader('isadmin')) {
            if($request->hasHeader('authorization')) {
                if(!$request->bearerToken()) return response()->json(['message' => 'Bearer Token Not Found!'], 404);
                $service = new personalaccesstokensService();
                $data = Crypt::decryptString(fun::denval(Crypt::decryptString($request->bearerToken()), true));
                $cek = $service->get(['id' => $data[0]['id']]);
                if(!$cek) return response()->json(['message' => 'Bearer Token Not Found!'], 404);
                return $next($request);
            }
            return response()->json(['message' => 'No Authorization Found!'], 404);
        }
        return response()->json(['message' => 'Unauthorized!'], 404);
    }
}
