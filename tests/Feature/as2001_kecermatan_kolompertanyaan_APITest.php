<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
use App\Models\User;
use App\Models\PersonalAccessTokens;
use App\Libraries\myfunction as fun;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

/*
test('all() return all kecermatan kolom pertanyaan', function() {
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
    ])->get('/api/kecermatan-kolompertanyaan');
    $response->assertStatus(200);
});

test('get() return one kecermatan kolom pertanyaan', function() {
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
    ])->get('/api/kecermatan/pertanyaan/1');
    $response->assertStatus(200);
});

test('allForTes() return all pertanyaan for test', function() {
    $response = $this->withHeaders([
        'tokenlogin' => 'a1b2c3d4e5',
        '--unique--' => 'I am unique!',
        'isvalid'    => 'VALID!',
        'isallowed'  => true,
        'key'        => 'key',
        'values'     => 'values',
        'isdumb'     => 'no',
        'challenger' => 'of course',
        'pranked'    => 'absolutely'
    ])->get('/api/psikotest/kecermatan/pertanyaan/1');
    $response->assertStatus(200);
});

test('save data kecermatan kolom pertanyaan', function() {
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
    ])->post('/api/kecermatan/kolompertanyaan', [
        'kolom_x' => 'kolom contoh',
        'nilai_A' => 1,
        'nilai_B' => 2,
        'nilai_C' => 3,
        'nilai_D' => 4,
        'nilai_E' => 5,
    ]);
    $response->assertStatus(201);
});

test('modifies data kecermatan kolom pertanyaan', function() {
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
    ])->put('/api/kecermatan/kolompertanyaan/1', [
        'nilai_A' => 1,
        'nilai_B' => 2,
        'nilai_C' => 3,
        'nilai_D' => 4,
        'nilai_E' => 5,
    ]);
    $response->assertStatus(200);
});

test('delete data kecermatan kolom pertanyaan', function() {
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
    ])->delete('/api/kecermatan/kolompertanyaan/1');
    $response->assertStatus(200);
});
*/