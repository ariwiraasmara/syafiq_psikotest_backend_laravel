<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
class ErrorHandlingController extends Controller {
    //
    public function repository(Request $request, $data) {
        return new Response([
            'error'     => -11,
            'pesan'     => 'Terjadi kesalahan pada repository',
            'data'      => $data
        ]);
    }

    public function service(Request $request, $data) {
        return new Response([
            'error'     => -12,
            'pesan'     => 'Terjadi kesalahan pada service',
            'data'      => $data
        ]);
    }

    public function controller(Request $request, $data) {
        return new Response([
            'error'     => -13,
            'pesan'     => 'Terjadi kesalahan pada controller',
            'data'      => $data
        ]);
    }
}
