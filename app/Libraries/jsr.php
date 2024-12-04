<?php
//! Copyright @ Syahri Ramadhan Wiraasmara (ARI)
namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class jsr {

    public function __construct(array $array = null, String $status = null) {
        
    }

    public static function print(array $array = null, String $status = null) {
        return response()->json($array, match($status){
            'ok'            => 200,
            'created'       => 201,
            'accepted'      => 202,
            'bad request'   => 400,
            'unauthorized'  => 401,
            'not found'     => 404,
            default         => 500
        });
    }

}
?>