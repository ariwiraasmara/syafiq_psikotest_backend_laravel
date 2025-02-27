<?php
// 
// 
// 
use App\Models\User;
use App\Models\PersonalAccessTokens;
use App\Libraries\myfunction as fun;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('successful login', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => 'a1b2c3d4e5'
    ])->post('/api/login', [
        'email' => 'ariwiraasmara.sc37@gmail.com',
        'password' => 'admin'
    ]);
    $response->assertStatus(200);
});

test('dashboard page', function() {
    $emailuser = 'ariwiraasmara.sc37@gmail.com';
    $user = User::where(['email' => $emailuser])->first();
    $pat = PersonalAccessTokens::where(['name' => $emailuser])->first();
    $response = $this->withHeaders([
        'tokenlogin'     => 'a1b2c3d4e5',
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

test('successful logout', function() {
    $response = $this->withHeaders([
        'X-Header'   => 'Value',
        'tokenlogin' => 'a1b2c3d4e5'
    ])->get('/api/logout');
    $response->assertStatus(200);
});

