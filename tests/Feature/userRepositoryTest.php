<?php

use App\Repositories\userRepository;
use App\Models\User;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(User::class);
    $this->repository = new userRepository($this->model);
});

test('get() returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1, 'name' => 'Test User']]));

    $result = $this->repository->get(['id' => 1]);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('name', 'Test User');
    expect($result)->not->toBe(0);
});

test('get() returns null when no data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(false);
    $result = $this->repository->get(['id' => 1]);
    expect($result)->toBeNull();
});

test('store() returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);
    $result = $this->repository->store(['name' => 'New User']);
    expect($result > 0)->toBeTrue();
});

test('store() returns 0 when creation fails', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 0]);
    $result = $this->repository->store(['name' => 'New User']);
    expect($result)->toBe(0);
});

test('update() returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);
    $result = $this->repository->update(1, ['name' => 'Updated User']);
    expect($result > 0)->toBeTrue();
});

test('update() returns 0 when no rows are affected', function () {
    $this->model->shouldReceive('where->update')->andReturn(0);
    $result = $this->repository->update(1, ['name' => 'Updated User']);
    expect($result)->toBe(0);
});

afterEach(function () {
    Mockery::close();
});