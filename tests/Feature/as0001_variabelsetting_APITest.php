<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
use App\Models\User;
use App\Models\PersonalAccessTokens;
use App\Libraries\myfunction as fun;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
    $this->emailuser = 'ariwiraasmara.sc37@gmail.com';
    $this->user = User::where(['email' => $this->emailuser])->first();
    $this->pat = PersonalAccessTokens::where(['name' => $this->emailuser])->first();
    // dd($this->pat);
    $this->encrypted_pat = fun::encrypt($this->pat);
    $this->remember_token = $this->user['remember_token'];
});

test('api variabel setting - sukses', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->get('/api/variabel-setting/variabel/asc/-?page=1');
    $response->assertStatus(200);
});

test('api variabel setting: fail - Unauthorized', function () {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->get('/api/variabel-setting/variabel/asc/-?page=1');
    $response->assertStatus(404);
});

test('api get variabel: sukses', function() {
    $response = $this->withHeaders([
        'Content-Type'   => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->get('/api/variabel-setting/1');
    $response->assertStatus(200);
});

test('api get variabel: fail - Not Found', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->get('/api/variabel-setting/999999');
    $response->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'pesan' => 'Data Setting Variabel',
                'data' => null
            ]);
});

test('api store variabel: sukses', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->postJson('/api/variabel-setting', [
        'variabel' => 'contoh variabel',
        'values'   => 'contoh values'
    ]);
    $response->assertStatus(201);
});

test('api store variabel: fail - Unauthorized', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->post('/api/variabel-setting', [
        'variabel' => 'contoh variabel',
        'values'   => 'contoh values'
    ]);
    $response->assertStatus(404);
});

test('api update variabel: sukses', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->putJson('/api/variabel-setting/2', [
        'variabel' => 'Updated Variabel',
        'values'   => 'Updated Values',
    ]);
    // return $response->ddJson();
    $response->assertStatus(200);
});

test('api update variabel: fail - Unauthorized', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->putJson('/api/variabel-setting/1', [
        'variabel' => 'Updated Variabel',
        'values' => 'Updated Values',
    ]);
    $response->assertStatus(404);
});

test('api update variabel: fail - ID Not Found', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->putJson('/api/variabel-setting/999999', [
        'variabel' => 'Updated Variabel',
        'values'   => 'Updated Values',
    ]);
    $response->assertStatus(200);
            // ->assertJson([
            //     'error'   => 2,
            //     'pesan'   => 'Gagal Memperbaharui Data Setting Variabel',
            //     'data'    => 0
            // ]);
});

test('api delete variabel: sukses', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->deleteJson('/api/variabel-setting/1');
    $response->assertStatus(200);
            // ->assertJson([
            //     'success' => 1,
            //     'pesan' => 'Berhasil Menghapus Data Setting Variabel',
            //     'data' => 1
            // ]);
    // $response->ddBody();
});

test('api delete variabel: fail - Unauthorized', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->deleteJson('/api/variabel-setting/1');
    $response->assertStatus(404);
});

test('api delete variabel: fail - ID Not Found', function() {
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.$this->encrypted_pat,
        'remember-token' => $this->remember_token,
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $this->emailuser,
        'islogin'        => true,
        'isadmin'        => true,
        '--unique--'     => 'I am unique!',
        'isvalid'        => 'VALID!',
        'isallowed'      => true,
        'key'            => 'key',
        'values'         => 'values',
        'isdumb'         => 'no',
        'challenger'     => 'of course',
        'pranked'        => 'absolutely'
    ])->deleteJson('/api/variabel-setting/999999',[]);
    $response->assertStatus(200)
            ->assertJson([
                'success' => 1,
                'pesan' => 'Gagal Menghapus Data Setting Variabel',
                'data' => 0
            ]);
});