<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;
use App\Libraries\myfunction as fun;
use App\Services\personalaccesstokensService;
class SecondBearerTokenCheck {
    /**
     * Handle an incoming request.
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if($request->hasHeader('islogin') && $request->hasHeader('isadmin') && $request->hasHeader('X-Chiron-F1')) {
            if($request->hasHeader('authorization') && $request->hasHeader('Bearer-Token')) {
                if(!$request->bearerToken()) return response()->json(['message' => 'Bearer Token Not Found!'], 404);
                $service = new personalaccesstokensService();
                $data = Crypt::decrypt(fun::denval(Crypt::decrypt($request->header('Bearer-Token')), true));
                $cek = $service->get(['id' => $data[0]['id']]);
                if(!$cek) return response()->json(['message' => 'Bearer Token Not Found!'], 404);
                return $next($request);
            }
            return response()->json(['message' => 'No Authorization Found!'], 404);
        }
        return response()->json(['message' => 'Unauthorized!'], 404);
    }
}
