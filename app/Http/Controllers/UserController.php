<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Services\userService;
use App\Services\useractivitiesService;
use App\Services\userdevicehistoryService;
use App\Services\personalaccesstokensService;
use App\Services\as1001_peserta_profilService;
use App\Libraries\branding;
use App\Libraries\jsr;
use App\Libraries\myfunction as fun;
use App\Libraries\session_reader as msr;
use Exception;

class UserController extends Controller {
    //
    protected userService|null $service;
    protected useractivitiesService|null $activity;
    protected userdevicehistoryService|null $devicehistory;
    protected personalaccesstokensService|null $patService;
    protected as1001_peserta_profilService|null $pesertaService;
    protected branding $brand;
    protected $titlepage, $path, $domain, $unique;
    public function __construct(
        userService $service,
        personalaccesstokensService $patService,
        as1001_peserta_profilService $pesertaService,
        useractivitiesService $activity,
        userdevicehistoryService $devicehistory,
        branding $brand
    ) {
        // ?
        $this->service = $service;
        $this->patService = $patService;
        $this->pesertaService = $pesertaService;
        $this->activity = $activity;
        $this->devicehistory = $devicehistory;
        $this->brand = $brand;

        // ?
        $this->titlepage = $this->brand->getTitlepage();
        $this->path      = env('SESSION_PATH', '/');
        $this->domain    = env('SESSION_DOMAIN', 'localhosthost:8000');
        $this->unique    = fun::random('combwisp', 50);

        // ?
    }

    #GET
    #url = '/api/user-admin-all'
    public function all(Request $request): Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Semua Data Admin!',
                'data'    => $this->service->all()
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->all!', [
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

    #GET
    #url = '/api/user-admin/{sort}/{by}/{search}?page=1'
    public function allWithSearch(Request $request, String $sort = null, String $by = null, String $search = null) : Response|JsonResponse|String|int|null {
        try {
            if($sort == 'null' || $sort == '' || $sort == ' ' || $sort == null) $sort = 'name';
            if($by == 'null' || $by == '' || $by == ' ' || $by == null) $by = 'asc';
            if($search == 'null' || $search == '' || $search == ' ' || $search == null) $search = null;
        
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca semua data pencarian admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success'   => 1,
                'pesan'     => 'Semua Data Pencarian Admin',
                'data'      => $this->service->allWithSearch($sort, $by, $search)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->allWithSearch!', [
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

    #GET
    #url = '/api/user-admin/{id}'
    public function get(Request $request, $id) : Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca satu data admin.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Data User!',
                'data'    => $this->service->get($id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->get!', [
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

    #GET
    #url = '/api/user-admin/{type}/{id}'
    public function detail(Request $request, $type, $id) : Response|JsonResponse|String|int|null {
        try {
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : membaca satu data admin detil.',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Data Detil User!',
                'data'    => $this->service->detail($type, $id)
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->detail!', [
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

    #POST
    #url = '/api/user-admin'
    public function store(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique'        => 'required',
                'name'          => 'required|string',
                'email'         => 'required|string',
                'no_identitas'  => 'required|string',
                'roles'         => 'required',
                'jk'            => 'required|string',
            ]);
            if($credentials) {
                $data = $this->service->store([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'no_identitas'  => $request->no_identitas,
                    'roles'         => $request->roles,
                    'jk'            => $request->jk,
                    'alamat'        => $request->alamat,
                    'status'        => $request->status,
                    'agama'         => $request->agama,
                    'foto'          => $request->foto
                ]);
                if($data > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'create and store : data admin baru.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success'   => 1,
                        'pesan'     => 'Berhasil Menyimpan Data User',
                        'data'      => $data
                    ], 'created');
                }
                else {
                    return jsr::print([
                        'error'  => 2,
                        'pesan'  => 'Gagal Menyimpan Data User',
                        'data'   => $data
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'=> -13,
                    'pesan' => 'Is Not Valid!'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->store!', [
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

    #PUT
    #url = '/api/user-admin-account'
    public function updateAccount(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique' => 'required',
                'roles'  => 'required',
            ]);
            if($credentials) {
                $res = $this->service->updateAccount($id, $request->roles);
                if($res > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : password baru pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Data User Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 2,
                        'pesan'  => 'Gagal Memperbaharui Data User',
                        'data'   => $res
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 3,
                    'pesan'  => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateAccount!', [
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

    #PUT
    #url = '/api/user-admin-password'
    public function updatePassword(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique'   => 'required',
                'password' => 'required',
            ]);
            if($credentials) {
                $res = $this->service->updatePassword($id, $request->password);
                if($res > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : password baru pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Password Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 2,
                        'pesan'  => 'Gagal Memperbaharui Password User',
                        'data'   => $res
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updatePassword!', [
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

    #PUT
    #url = '/api/user-remembertoken'
    public function updateRemembertoken(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $res = $this->service->updateRememberToken($id);
                if($res) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'update : remember token baru pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Remember Token User Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 1,
                        'pesan'  => 'Gagal Memperbaharui Remember Token User',
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateRemembertoken!', [
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

    #PUT
    #url = '/api/user-admin-pat'
    public function updatePAT(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $res = $this->service->updatePAT($id);
                if($res) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'update : Personal Access Token pada akunku.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'PAT User Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 1,
                        'pesan'  => 'Gagal Memperbaharui PAT User',
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updatePAT!', [
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

    #PUT
    #url = '/api/user-admin-profil'
    public function updateProfil(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique'        => 'required',
                'no_identitas'  => 'required',
                'roles'         => 'required',
                'jk'            => 'required',
            ]);
            if($credentials) {
                $data2 = $this->service->updateProfil($id, [
                    'no_identitas'  => $request->no_identitas,
                    'jk'            => $request->jk,
                    'alamat'        => $request->alamat,
                    'status'        => $request->status,
                    'agama'         => $request->agama,
                ]);

                $data1 = $this->service->updateAccount($id, [
                    'roles' => $request->roles
                ]);

                if($data2 > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : data admin yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Profil User Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 1,
                        'pesan'  => 'Gagal Memperbaharui Profil User',
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateProfil!', [
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

    #PUT
    #url = '/api/user-admin-foto'
    public function updateFoto(Request $request, $id): Response|JsonResponse|String|int|null {
        try {
            $credentials = $request->validate([
                'unique' => 'required',
                'foto'   => 'required|mimes:png,webp|max:2048',
            ]);
            if($credentials) {
                $data = $this->service->get($id);
                $foto = $request->file('avatar')->storeAs(
                    'private_admin_foto',
                    $data[0]['id'].'.'.$data[0]['email'].'.'.$request->file('foto')->extension(),
                    'public'
                );
                $res = $this->service->updateFoto($id, [
                    'foto' => $foto,
                ]);

                if($res > 0) {
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'edit and update : data admin yang sudah ada.',
                        'properties' => json_encode($request->all())
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan' => 'Foto User Berhasil Diperbaharui!'
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error'  => 1,
                        'pesan'  => 'Gagal Memperbaharui Foto User',
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error'  => 2,
                    'pesan'  => 'Invalid Credentials',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->updateFoto!', [
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

    #DELETE
    #url = '/api/user-admin/{type}/{id}'
    public function delete(Request $request, $type, $id): Response|JsonResponse|String|int|null {
        try {
            if($id) {
                $data = $this->service->get($id);
                if($type == 'hard') $res = $this->service->hardDelete($id);
                else $res = $this->service->softDelete($id);
                if($res > 0) {
                    $properties = collect([
                        'data'       => $data,
                        'type'       => 'soft delete',
                        'deletec_at' => date('Y-m-d H:i:s')
                    ])->toJson();
                    $token = msr::read($request->bearerToken());
                    $this->activity->store([
                        'id_user'    => $token['id'],
                        'ip_address' => $request->ip(),
                        'path'       => $request->path(),
                        'url'        => $request->fullUrl(),
                        'page'       => $request->header()['titlepage'][0].$this->titlepage,
                        'event'      => 'API - '.$request->method(),
                        'deskripsi'  => 'soft delete : menghapus data admin (soft)',
                        'properties' => $properties
                    ]);
                    return jsr::print([
                        'success' => 1,
                        'pesan'   => 'Berhasil Menghapus Data Admin',
                        'data'    => $res
                    ], 'ok');
                }
                else {
                    return jsr::print([
                        'error' => 2,
                        'pesan' => 'Gagal Menghapus Data Admin',
                        'data'  => $res
                    ], 'bad request');
                }
            }
            else {
                return jsr::print([
                    'error' => 1,
                    'pesan' => 'Invalid Credentials!',
                ], 'bad request');
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->softDelete!', [
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

    #POST
    #url = '/api/login/';
    public function login(Request $request) {
        try {
            $credentials = $request->validate([
                'email'     => ['required'],
                'password'  => ['required'],
            ]);
            if($credentials) {
                $login_at = date('Y-m-d H:i:s');
                $filename = date('Ymd');
                $data = $this->service->login([
                    'email'      => fun::readable($request->email),
                    'pass'       => fun::readable($request->password),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('user-agent'),
                    'login_at'   => $login_at,
                    'filename'   => $filename
                ]);
                // return $data['success'];
                if($data['success'] > 0) {
                    if(Auth::attempt($credentials, true)) {
                        $user = Auth::user();
                        Auth::login($user, true);
                        $userDetil = $this->service->detail('id', $data['data'][0]['id']);
                        // $token = fun::encrypt($user->createToken($request->email, ['server:update'])->plainTextToken);
                        // return $userDetil['user'][0];
                        $pat = $this->patService->get(['name' => $request->email]);
                        $tokenExpire = $pat[0]['expires_at'];
                        if($pat[0]['expires_at'] == date('Y-m-d 00:00:00')) {
                            $this->patService->update($pat[0]['id'],[
                                'last_used_at'  => now(),
                                'expires_at'    => fun::daysLater('+7 days'),
                                'updated_at'    => date('Y-m-d H:i:s')
                            ]);
                            $this->service->updateRemembertoken($data['data'][0]['id'], fun::random('combwisp', 100));
                        }
                        else {
                            $this->patService->update($pat[0]['id'],[
                                'last_used_at' => now()
                            ]);
                        }
                        $unique = fun::random('combwisp', 40);
                        $token = fun::random('combwisp', 40);
                        $sysauth = fun::random('combwisp', 100);
                        $expirein = 6 * 60; // jam * menit

                        $profil = [
                            'id'           => $data['data'][0]['id'],
                            'nama'         => $data['data'][0]['name'],
                            'email'        => $data['data'][0]['email'],
                            'roles'        => $data['data'][0]['roles'],
                            'no_identitas' => $userDetil['user'][0]['no_identitas'],
                            'foto'         => $userDetil['user'][0]['foto'],
                            'admin'        => 1,
                        ];

                        $jwt =  Crypt::encrypt(fun::enval(Crypt::encrypt($pat), true));
                        $rememberToken = fun::enval($data['data'][0]['remember_token'], true);

                        $rfdt = [
                            'success' => 1,
                            'pesan'   => 'Yehaa! Berhasil Login!',
                            'data'    => [
                                'pas_bah' => fun::enval(Crypt::encrypt($profil), true),
                                'pas_tit' => $jwt,
                                'pas_tek' => $rememberToken,
                            ],
                            'sesi'    => [
                                'expire_at'   => $tokenExpire,
                                'pas_sisis'   => fun::encrypt($request->email),
                                'pas_ukulele' => $unique,
                                'pas_tkesdeh' => $token,
                                'pas_tkempeh' => csrf_token(),
                                'pas_qiqi'    => $unique,
                            ]
                        ];

                        $this->activity->store([
                            'id_user'    => $data['data'][0]['id'],
                            'ip_address' => $request->ip(),
                            'path'       => $request->path(),
                            'url'        => $request->fullUrl(),
                            'page'       => 'Login | Admin'.$this->titlepage,
                            'event'      => 'API - '.$request->method(),
                            'deskripsi'  => 'login : masuk sistem admin user : '.$data['data'][0]['name'],
                            'properties' => json_encode($request->all())
                        ]);

                        $response = new Response($rfdt);
                        return $response
                                ->cookie('_pas-g1', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-m2', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-t3', true, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-x4', fun::daysLater('+12 hours'), $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-m5', $request->email, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-sys', $sysauth, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-kn', $token, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('_pas-nq', $unique, $expirein, $this->path, $this->domain, true, true, false, 'Strict')
                                ->cookie('XSRF-TOKEN', csrf_token(), $expirein, $this->path, $this->domain, true, true, false, 'Strict');
                    }
                }
                else {
                    return match($data['error']){
                        1 => jsr::print([
                            'pesan' => 'Username / Email Salah!',
                            'error'=> 1
                        ], 'bad request'),
                        2 => jsr::print([
                            'pesan' => 'Password Salah!',
                            'error'=> 2
                        ],'bad request'),
                        default => jsr::print([
                            'pesan' => 'Terjadi Kesalahan!',
                            'error'=> -1
                        ])
                    };
                }
            }
            else {
                return jsr::print([
                    'error'=> -13,
                    'pesan' => 'Is Not Valid!'
                ]);
            }
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->login!', [
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

    #GET
    #url = '/api/logout/'
    public function logout(Request $request): Response|JsonResponse|String|int|null {
        try {
            if ($request->user() && $request->user()->token()) {
                $request->user()->token()->revoke();
            }
            $response = new Response([
                'success' => 1,
                'pesan'   => 'Akhirnya Logout!',
                'sesi'    => [
                    'expire_at' => fun::daysLater('+6 hours')
                ]
            ]);
            $token = msr::read($request->bearerToken());
            $this->activity->store([
                'id_user'    => $token['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => $request->header()['titlepage'][0].$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'login : masuk sistem admin user : '.$request->session_name,
                'properties' => json_encode($request->all())
            ]);
            return $response->cookie('email', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('nama', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('islogin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('isadmin', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('isauth', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__sysauth__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__token__', null, -1, $this->path, $this->domain, true, true, false, 'Strict')
                            ->cookie('__unique__', null, -1, $this->path, $this->domain, true, true, false, 'Strict');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->logout!', [
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

    #GET
    #url = '/api/dashboard_admin/'
    public function dashboard(Request $request) {
        try {
            // return $request->header('Bearer-Token');
            $token = msr::read($request->header('Bearer-Token'));
            $this->activity->store([
                'id_user'    => $token[0]['id'],
                'ip_address' => $request->ip(),
                'path'       => $request->path(),
                'url'        => $request->fullUrl(),
                'page'       => 'Dashboard | Admin'.$this->titlepage,
                'event'      => 'API - '.$request->method(),
                'deskripsi'  => 'read : melihat data di halaman dashboard',
                'properties' => json_encode($request->all())
            ]);
            return jsr::print([
                'success' => 1,
                'pesan'   => 'Dashboard!',
                'by_user' => Crypt::decrypt(fun::denval($request->header('X-Chiron-F1'), true)),
                'data'    => $this->pesertaService->allLatest()
            ], 'ok');
        }
        catch(Exception $err) {
            Log::channel('error-controllers')->error('Terjadi kesalahan pada UserController->dashboard!', [
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

    public function __destruct() {
        $this->service        = null;
        $this->patService     = null;
        $this->pesertaService = null;
        $this->activity       = null;
        $this->devicehistory  = null;
        $this->titlepage      = null;
        $this->path           = null;
        $this->domain         = null;
        $this->unique         = null;
    }
}
