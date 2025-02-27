<?php

use App\Repositories\as0001_variabelsettingRepository;
use App\Models\as0001_variabelsetting;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(as0001_variabelsetting::class);
    $this->repository = new as0001_variabelsettingRepository($this->model);
});

test('all() returns collection when data exists', function () {
    $this->model->shouldReceive('first')->andReturn(true);
    $this->model->shouldReceive('orderBy->where->limit->paginate->toArray')->andReturn(['data' => 'test']);

    $result = $this->repository->all();

    expect($result)->toBeArray();
    expect($result)->toHaveKey('data', 'test');
});

test('get() returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->get(['id' => 1]);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('store() returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);
    $result = $this->repository->store(['variabel' => 'test', 'values' => 'value']);
    expect($result)->toBe(1);
});

test('update() returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);
    $result = $this->repository->update(1, ['variabel' => 'updated']);
    expect($result)->toBe(1);
});

test('delete() returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->delete')->andReturn(1);
    $result = $this->repository->delete(1);
    expect($result)->toBe(1);
});

afterEach(function () {
    Mockery::close();
});
?>