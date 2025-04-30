<?php
//! Copyright @
//! Syafiq
//! Syahri Ramadhan Wiraasmara (ARI)
use App\Models\User;
use App\Models\PersonalAccessTokens;
use App\Libraries\myfunction as fun;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('api variabel setting - sukses', function() {
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
    ])->get('/api/variabel-setting/variabel/asc/null/');
    $response->assertStatus(200);
});

test('detail variabel page', function() {
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
    ])->get('/api/variabel-setting/1');
    $response->assertStatus(200);
});

test('saves data variabel', function() {
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
    ])->post('/api/variabel-setting', [
        'variabel' => 'contoh variabel',
        'values'   => 'contoh values'
    ]);
    $response->assertStatus(201);
});

test('modifies data variabel', function() {
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
    ])->put('/api/variabel-setting/1', [
        'variabel' => 'Updated Variabel',
        'values' => 'Updated Values',
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
    ])->delete('/api/variabel-setting/1');
    $response->assertStatus(200);
});