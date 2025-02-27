<?php

use App\Repositories\personalaccesstokensRepository;
use App\Models\PersonalAccessTokens;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(PersonalAccessTokens::class);
    $this->repository = new personalaccesstokensRepository($this->model);
});

test('get() returns collection when data exists', function () {
    $result = $this->repository->get(['name' => 'ariwiraasmara.sc37@gmail.com']);
    expect($result)->not->toBe(0);
    expect($result)->toBeIterable();
});

test('get() returns 0 when no data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(false);
    $result = $this->repository->get(['id' => 1]);
    expect($result)->toBe(0);
    expect($result)->not->toBeIterable();
});

test('update() returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);
    $result = $this->repository->update(1, [
        'abilities' => '["*"]',
        'token' => 'new-token'
    ]);
    expect($result)->not->tobeNull();
    expect($result)->toBeInt();
    expect($result)->toBeGreaterThan(0); // => harusnya yang ini juga!
});

test('update() returns 0 when no rows are affected', function () {
    $this->model->shouldReceive('where->update')->andReturn(0);
    $result = $this->repository->update(1, ['token' => 'new-token']);
    expect($result)->toBe(0);
});

afterEach(function () {
    Mockery::close();
});