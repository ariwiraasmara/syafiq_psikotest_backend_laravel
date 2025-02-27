<?php
// 
// 
// 
use App\Repositories\userRepository;
use App\Services\userService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    // Membuat mock untuk userRepository
    $this->repo = $this->createMock(userRepository::class);

    // Membuat instance userService dengan dependensi yang di-mock
    $this->userService = new userService($this->repo);
});

test('login() => Success and Valid!', function () {
    // Menyiapkan data uji
    $email = 'ariwiraasmara.sc37@gmail.com';
    $pass = 'admin';
    $user = new Collection([['email' => $email, 'password' => Hash::make($pass)]]);
    $this->repo->method('get')->willReturn($user);

    // Menjalankan metode login
    $result = $this->userService->login($email, $pass);

    // Memastikan hasil sesuai dengan yang diharapkan
    expect($result->get('success'))->toBe(1);
    expect($result->get('pesan'))->toBe('Yehaa! Berhasil Login!');
});

test('login() => Fail and Invalid! Dengan Email yang salah!', function () {
    // Menyiapkan data uji
    $email = 'wrong@example.com';
    $pass = 'admin';
    $this->repo->method('get')->willReturn(null);

    // Menjalankan metode login
    $result = $this->userService->login($email, $pass);

    // Memastikan hasil sesuai dengan yang diharapkan
    expect($result->get('error'))->toBe(1);
    expect($result->get('pesan'))->toBe('Email Salah!');
});

test('login() => Fail and Invalid! Dengan password yang salah', function () {
    // Menyiapkan data uji
    $email = 'ariwiraasmara.sc37@gmail.com';
    $pass = 'wrongpassword';
    $user = new Collection([['email' => $email, 'password' => Hash::make('password123')]]);
    $this->repo->method('get')->willReturn($user);

    // Menjalankan metode login
    $result = $this->userService->login($email, $pass);

    // Memastikan hasil sesuai dengan yang diharapkan
    expect($result->get('error'))->toBe(2);
    expect($result->get('pesan'))->toBe('Password Salah! Silahkan Coba Lagi!');
});

test('updateRemembertoken() => Success and Valid!', function() {
    // Menyiapkan data uji
    $id = 1;
    $token = 'newRememberToken';

    // Mengonfigurasi metode update untuk mengembalikan nilai yang lebih besar dari 0
    $this->repo->method('update')->willReturn(1);

    // Menjalankan metode updateRemembertoken
    $result = $this->userService->updateRemembertoken($id, $token);

    // Memastikan hasil sesuai dengan yang diharapkan
    expect($result)->toBe($token);
});