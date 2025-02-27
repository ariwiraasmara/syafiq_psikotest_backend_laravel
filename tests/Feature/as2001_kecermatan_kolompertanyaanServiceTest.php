<?php

use App\Services\as2001_kecermatan_kolompertanyaanService;
use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->repo = Mockery::mock(as2001_kecermatan_kolompertanyaanRepository::class);
    $this->service = new as2001_kecermatan_kolompertanyaanService($this->repo);
});

test('all() returns data correctly', function () {
    $this->repo->shouldReceive('all')->andReturn(collect(['data' => 'test']));
    $result = $this->service->all();
    expect($result)->toBeInstanceOf(Collection::class);
});

test('allForTes() returns data correctly', function () {
    $this->repo->shouldReceive('allForTes')->with(1)->andReturn(collect(['data' => 'test']));
    $result = $this->service->allForTes(1);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('get() returns data correctly', function () {
    $this->repo->shouldReceive('get')->with(1)->andReturn(collect(['data' => 'test']));
    $result = $this->service->get(1);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('store() saves data correctly', function () {
    $this->repo->shouldReceive('store')->andReturn(1);
    $result = $this->service->store([
        'kolom_x' => 'X',
        'nilai_A' => 10,
        'nilai_B' => 20,
        'nilai_C' => 30,
        'nilai_D' => 40,
        'nilai_E' => 50,
    ]);
    expect($result)->toBe(1);
});

test('update() modifies data correctly', function () {
    $this->repo->shouldReceive('update')->andReturn(1);
    $result = $this->service->update(1, [
        'nilai_A' => 15,
        'nilai_B' => 25,
        'nilai_C' => 35,
        'nilai_D' => 45,
        'nilai_E' => 55,
    ]);
    expect($result)->toBe(1);
});

test('delete() removes data correctly', function () {
    $this->repo->shouldReceive('delete')->andReturn(1);
    $result = $this->service->delete(1);
    expect($result)->toBe(1);
});

afterEach(function () {
    Mockery::close();
});