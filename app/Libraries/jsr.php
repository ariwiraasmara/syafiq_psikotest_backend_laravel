<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class jsr {

    public function __construct(array $array = null, String $status = null) {
        
    }

    public static function print(array $array = null, String $status = null) {
        return response()->json($array, match($status){
            'ok'                 => 200,
            'created'            => 201,
            'accepted'           => 202,
            'bad request'        => 400,
            'unauthorized'       => 401,
            'forbidden'          => 403,
            'not found'          => 404,
            'method not allowed' => 405,
            'not acceptable'     => 406,
            'conflict'           => 409,
            'gone'               => 410,
            default              => 500
        });
    }

}
?>