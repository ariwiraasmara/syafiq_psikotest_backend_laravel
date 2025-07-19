<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class Pranker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if($request->hasHeader('--unique--') && ($request->header()['--unique--'][0] == 'I am unique!')) {
            if($request->hasHeader('isvalid') && $request->hasHeader('isallowed')) {
                if($request->header()['isvalid'][0] == 'VALID!') {
                    if( ($request->hasHeader('key')
                            && $request->hasHeader('values'))
                            && (!empty($request->header()['key'][0]))
                            && (!empty($request->header()['values'][0]))
                    ) {
                        if($request->hasHeader('isdumb') && $request->header()['isdumb'][0] == 'no') {
                            if($request->hasHeader('challenger') && $request->header()['challenger'][0] == 'of course') {
                                if($request->hasHeader('pranked') && $request->header()['pranked'][0] == 'absolutely') {
                                    return $next($request);
                                }
                                return response()->json(['message' => "HAHAHA!!! YOU DUMBASS! You got PRANKED!!! JUST GO HOME DICK!"], 404);
                            }
                            return response()->json(['message' => "I see. So you're a challenger, eh..."], 404);
                        }
                        return response()->json(['message' => "You're even DUMB ASSHOLE!!! YOU DUMBASSS"], 404);
                    }
                    return response()->json(['message' => "Gubrak! There's no even key and it's values! Gimme the key and it's values!"], 404);
                }
                return response()->json(['message' => 'IT IS VALID! BUT NOT VALID AS WELL!'], 404);
            }
            return response()->json(['message' => 'This not even valid! Or Even allowed!'], 404);
        }
        return response()->json(['message' => 'Where is the uniqueness?'], 404);
    }
}
