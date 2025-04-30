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

test('semua hasil tes peserta tertentu', function() {
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
    ])->get('/api/peserta/hasil/psikotest/kecermatan/semua/1');
    $response->assertStatus(200);
});

test('semua hasil tes peserta tertentu berdasarkan antara 2 tanggal', function() {
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
    ])->get('/api/peserta/hasil/psikotest/kecermatan/1/2024-01-01/2024-02-02');
    $response->assertStatus(200);
});

test('semua hasil tes peserta tertentu berdasarkan tanggal', function() {
    $response = $this->withHeaders([
        'tokenlogin' => 'a1b2c3d4e5',
    ])->get('/api/peserta-hasil-tes/1/2024-01-01');
    $response->assertStatus(200);
});

test('saves data hasil tes kecermatan peserta', function() {
    $response = $this->withHeaders([
        'tokenlogin'     => 'a1b2c3d4e5',
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
    ])->post('/api/peserta-hasil-tes/1', [
        'hasilnilai_kolom_1' => 50,
        'hasilnilai_kolom_2' => 30,
        'hasilnilai_kolom_3' => 45,
        'hasilnilai_kolom_4' => 20,
        'hasilnilai_kolom_5' => 40,
    ]);
    $response->assertStatus(201);
});