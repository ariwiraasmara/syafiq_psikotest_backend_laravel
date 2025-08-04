<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Exception;


class GenerateSignedURLController extends Controller {
    //
    public function signedURL(Request $request, $routeName) {
        try {
            $params = @$_GET['params'];
            $signedUrl = URL::signedRoute($routeName, $params, absolute: true) ?? null;
            return $signedUrl;
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada GenerateSignedURLController->signedURL!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }

    public function signedTemporaryURL(Request $request, $routeName, $minutes) {
        try {
            $params = $request->query('params');
            $signedUrl = URL::temporarySignedRoute($routeName, now()->addMinutes($minutes), $params) ?? null;
            return $signedUrl;
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada GenerateSignedURLController->signedTemporaryURL!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error'=> -13,
                'pesan' => 'Terjadi Kesalahan! Lihat Log!'
            ]);
        }
    }
}
