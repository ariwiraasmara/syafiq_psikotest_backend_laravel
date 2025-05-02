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

/*
test('api login: sukses - dengan email dan password yang benar', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => fun::random('combwisp', 50)
    ])->post('/api/login', [
        'email' => 'ariwiraasmara.sc37@gmail.com',
        'password' => 'admin'
    ]);
    $response->assertStatus(200);
});

test('api login: gagal - dengan email yang benar dan password yang salah', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => fun::random('combwisp', 50)
    ])->post('/api/login', [
        'email' => 'ariwiraasmara.sc37@gmail.com',
        'password' => 'admn'
    ]);
    $response->assertStatus(500);
});

test('api login: gagal - dengan email yang salah dan password yang salah', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => fun::random('combwisp', 50)
    ])->post('/api/login', [
        'email' => 'ariwirmara.sc37@gmail.com',
        'password' => 'admn'
    ]);
    $response->assertStatus(500);
});

test('api login: gagal - dengan email yang salah dan password yang benar', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => fun::random('combwisp', 50)
    ])->post('/api/login', [
        'email' => 'ariwirmara.sc37@gmail.com',
        'password' => 'admin'
    ]);
    $response->assertStatus(500);
});

test('api dashboard: sukses', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'tokenlogin'     => fun::random('combwisp', 50),
        'email'          => $emailuser,
        'remember-token' => $user['remember_token'],
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
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
    ])->get('/api/dashboard_admin');
    $response->assertStatus(200);
});

test('api dashboard: gagal - No tokenlogin', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'email'          => $emailuser,
        'remember-token' => $user['remember_token'],
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
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
    ])->get('/api/dashboard_admin');
    $response->assertStatus(404);
});

test('api dashboard: gagal - invalid email, Null Authorization and remember-token', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail';
    $user = User::where(['email' => $emailuser])->first();
    if($user) {
        $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
        $response = $this->withHeaders([
            'tokenlogin'     => fun::random('combwisp', 50),
            'email'          => $emailuser,
            'remember-token' => $user['remember_token'],
            'Authorization'  => 'Bearer '.fun::encrypt($pat),
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
        ])->get('/api/dashboard_admin');
        $response->assertStatus(200);
    }
    else {
        $response = $this->withHeaders([
            'tokenlogin'     => fun::random('combwisp', 50),
            'email'          => $emailuser,
            'remember-token' => null,
            'Authorization'  => null,
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
        ])->get('/api/dashboard_admin');
        $response->assertStatus(404);
    }
});

test('api dashboard: gagal - No Authorization Header', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'tokenlogin'     => fun::random('combwisp', 50),
        'email'          => $emailuser,
        'remember-token' => $user['remember_token'],
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
    ])->get('/api/dashboard_admin');
    $response->assertStatus(404);
});

test('api dashboard: gagal - No remember-token', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'tokenlogin'     => fun::random('combwisp', 50),
        'email'          => $emailuser,
        'Authorization'  => 'Bearer '.fun::encrypt($pat),
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
    ])->get('/api/dashboard_admin');
    $response->assertStatus(404);
});

test('api logout: sukses', function() {
    $response = $this->withHeaders([
        'tokenlogin' => fun::random('combwisp', 50),
    ])->get('/api/logout');
    $response->assertStatus(200);
});

test('api logout: gagal - No tokenlogin', function() {
    $response = $this->withHeaders([

    ])->get('/api/logout');
    $response->assertStatus(404);
});
*/