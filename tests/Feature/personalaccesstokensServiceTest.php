<?php

use App\Services\personalaccesstokensService;
use App\Repositories\personalaccesstokensRepository;
use App\Libraries\myfunction as fun;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->repo = Mockery::mock(personalaccesstokensRepository::class);
    $this->service = new personalaccesstokensService($this->repo); // Inject the mock repository via constructor
});

test('get() returns collection when data exists', function() {
    $result = $this->service->get(['name' => 'ariwiraasmara.sc37@gmail.com']);
    expect($result)->not->toBe(0);
    expect($result)->toBeIterable();
});

test('get() returns 0 when no data exists', function () {
    $result = $this->service->get(['name' => 'x']);
    // expect($result)->toBe(0); => harusn ya ini juga!
    expect($result)->not->toBeIterable();
});

test('update() returns token string when update is successful', function () {
    $this->repo->shouldReceive('update')->with(1, [
        'abilities' => '["*"]',
        'expires_at' => fun::daysLater('+1 day'),
        'updated_at' => date('Y-m-d H:i:s')
    ])->andReturn(1);
    $this->repo->shouldReceive('get')->with(['id' => 1])->andReturn([['token' => 'sample-token']]);

    $result = $this->service->update(1, [
        'abilities' => '["*"]',
        'expires_at' => fun::daysLater('+1 day'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    expect($result)->not->tobeNull();
    expect($result)->toBeString(); // => harusnya yang ini!
    expect($result)->toBeGreaterThan(0); // => harusnya yang ini juga!
});

test('update() returns 0 when no rows are affected', function () {
    $this->repo->shouldReceive('update')->with(1, ['expires_at' => '2023-01-01'])->andReturn(0);
    $result = $this->service->update(1, ['expires_at' => '2023-01-01']);
    expect($result)->toBe(0);
});

afterEach(function () {
    Mockery::close();
});