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
});

/*
test('all peserta page', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->get('/api/peserta/variabel/asc/null/');
    $response->assertStatus(200);
});

test('get peserta page', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Content-Type'  => 'application/json',
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->get('/api/peserta/1');
    $response->assertStatus(200);
});

test('saves data peserta', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->post('/api/peserta', [
        'nama'         => 'mr. x',
        'no_identitas' => '123456789',
        'email'        => 'mrx@gmail.com',
        'tgl_lahir'    => '2000-01-01',
        'asal'         => 'xxx',
    ]);
    $response->assertStatus(201);
});

test('setup data peserta', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->post('/api/peserta/setup', [
        'nama'         => 'mr. x',
        'no_identitas' => '123456789',
        'email'        => 'mrx@gmail.com',
        'tgl_lahir'    => '2000-01-01',
        'asal'         => 'xxx',
        'tgl_tes'      => '2023-01-01',
    ]);
    $response->assertStatus(200);
});

test('modifies data peserta', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->put('/api/peserta/1', [
        'email'        => 'mrx@gmail.com',
        'tgl_lahir'    => '2000-01-01',
        'asal'         => 'xxx',
    ]);
    $response->assertStatus(200);
});

test('delete data variabel', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
        'remember-token' => $user['remember_token'],
        'tokenlogin'     => 'a1b2c3d4e5',
        'email'          => $emailuser,
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
    ])->delete('/api/peserta/1');
    $response->assertStatus(200);
});
*/