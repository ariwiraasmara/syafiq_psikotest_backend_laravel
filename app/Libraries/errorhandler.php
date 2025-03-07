<?php
//! Copyright @ Syahri Ramadhan Wiraasmara (ARI)
namespace App\Libraries;
use Illuminate\Support\Facades\Log;
class errorhandler {

    public static function exception($err, int $err_code, String $err_type, String $err_message) {
        Log::channel($err_type)->error($err_message, [
            'message' => $err->getMessage(),
            'file' => $err->getFile(),
            'line' => $err->getLine(),
            'trace' => $err->getTraceAsString(),
        ]);
        return jsr::print([
            'error'=> $err_code,
            'pesan' => 'Terjadi Kesalahan! Lihat Log!'
        ]);
    }

}