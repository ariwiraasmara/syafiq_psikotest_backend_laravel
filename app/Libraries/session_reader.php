<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Libraries;

use Illuminate\Support\Facades\Crypt;
use App\Libraries\myfunction as fun;

class session_reader {

    public static function read($token_jwt) {
        // fun::encrypt(Crypt::encrypt($profil), true)
        $data = Crypt::decrypt(fun::denval(Crypt::decrypt($token_jwt), true));
        return $data;
    }

}