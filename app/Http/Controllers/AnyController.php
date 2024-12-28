<?php

namespace App\Http\Controllers;

use App\Services\userService;
use App\Services\personalaccesstokensService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class AnyController extends Controller {
    //

    protected userService $service;
    protected personalaccesstokensService $patService;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService) {
            $this->service = $service;
            $this->patService = $patService;
    }

    public function csrf_token() {
        try {
            $response = new Response([
                'success' => 1,
                'pesan'   => 'CSRF TOKEN!',
                'data'    => csrf_token()
            ]);
            $response->withCookie(cookie('csrf_token', csrf_token(), 1));
            return $response;
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada AnyController->generate_token_first!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return new Response([
                'error' => 1,
                'pesan' => 'Generate Unique Token Gagal! Lihat Log!'
            ]);
        }
    }

    public function generate_token_first() {
        try {
            $token = fun::random('combwisp', 50);
            $unique = fun::random('combwisp', 50);
            $response = new Response([
                'success' => 1,
                'pesan'   => 'Generate Unique Token Berhasil!',
                'data'    => [
                    'token' => $token,
                    'unique' => $unique
                ]
            ]);
    
            $expirein = 6 * 60; // jam * menit
            $response->withCookie(cookie('csrf-token', csrf_token(), $expirein));
            $response->withCookie(cookie('__token__', $token, $expirein));
            $response->withCookie(cookie('__unique__', $unique, $expirein));
            return $response;
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada AnyController->generate_token_first!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return new Response([
                'error' => 1,
                'pesan' => 'Generate Unique Token Gagal! Lihat Log!'
            ]);
        }
    }

    public function token_admin(Request $request) {
        try {
            $data = $this->service->login($request->email, $request->password);
            if($data['success']) {
                $credentials = $request->validate([
                    'email'     => ['required'],
                    'password'  => ['required'],
                ]);
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    $token = $user->createToken($request->email)->plainTextToken;
                    $response = new Response([
                        'success' => 1,
                        'pesan'   => 'Generate Token Admin Berhasil!',
                        'nama'    => $data['data'][0]['name'],
                        'email'   => $request->email,
                        'token'   => $token
                    ]);
                    return $response;
                }
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada AnyController->testAPIwithAnyMiddleware!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error' => 1,
                'pesan' => 'Generate Token Admin Gagal! Lihat Log!'
            ]);
        }
    }

    public function testAdminToken(Request $request) {
        try {
            $decrypted = fun::decrypt($request->bearerToken());
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Generate Token Admin Berhasil!',
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada AnyController->testAPIwithAnyMiddleware!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error' => 1,
                'pesan' => 'Generate Token Admin Gagal! Lihat Log!'
            ]);
        }
    }

    public function testAPIwithAnyMiddleware(Request $request) {
        try {
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Test API dengan berbagai macam Middleware Berhasil!',
                'data'    => [
                    'header'                => $request->header(),
                    'body'                  => $request,
                    'ipaddress'             => $request->ip(),
                    'multiple_ipaddress'    => $request->ips(),
                    'method'                => $request->method(),
                    'url'                   => $request->fullUrl(),
                    'params'                => $request->all(),
                    'email'                 => $request->header()['email'][0]
                ]
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada AnyController->testAPIwithAnyMiddleware!', [
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'trace' => $err->getTraceAsString(),
            ]);
            return jsr::print([
                'error' => 1,
                'pesan' => 'Generate Token Admin Gagal! Lihat Log!'
            ]);
        }
    }
}
