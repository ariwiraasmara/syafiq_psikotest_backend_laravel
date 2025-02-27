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

test('allRaw() return all kecermatan soaljawaban', function() {
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
    ])->get('/api/kecermatan/soaljawaban/all/1');
    $response->assertStatus(200);
});

test('allCooked() return kecermatan soaljawaban', function() {
    $response = $this->withHeaders([
        'tokenlogin'     => 'a1b2c3d4e5',
    ])->get('/api/kecermatan/soaljawaban/1');
    $response->assertStatus(200);
});

test('allForTes() return all soaljawaban for test', function() {
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
    ])->get('/api/psikotest/kecermatan/soaljawaban/1');
    $response->assertStatus(200);
});

test('save data kecermatan kolom soaljawaban', function() {
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
    ])->post('/api/kecermatan/soaljawaban/1', [
        'soal_jawaban' => '{id: 1}',
    ]);
    $response->assertStatus(201);
});

test('modifies data kecermatan kolom soaljawaban', function() {
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
    ])->put('/api/kecermatan/soaljawaban/1', [
        'soal_jawaban' => '{id: 1}',
    ]);
    $response->assertStatus(200);
});

test('delete data kecermatan kolom soaljawaban', function() {
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
