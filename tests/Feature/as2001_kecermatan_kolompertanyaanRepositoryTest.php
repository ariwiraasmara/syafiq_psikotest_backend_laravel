<?php

use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Models\as2001_kecermatan_kolompertanyaan;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(as2001_kecermatan_kolompertanyaan::class);
    $this->repository = new as2001_kecermatan_kolompertanyaanRepository($this->model);
});

test('all method returns collection when data exists', function () {
    $this->model->shouldReceive('first')->andReturn(true);
    $this->model->shouldReceive('orderBy->get')->andReturn(collect([['kolom_x' => 'A']]));

    $result = $this->repository->all();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('kolom_x', 'A');
});

test('get method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->Orwhere->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->get(1);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('allForTes method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->allForTes(1);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('store method returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);

    $result = $this->repository->store(['kolom_x' => 'A']);

    expect($result)->toBe(1);
});

test('update method returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);

    $result = $this->repository->update(1, ['kolom_x' => 'B']);

    expect($result)->toBe(1);
});

test('delete method returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->delete')->andReturn(1);

    $result = $this->repository->delete(1);

    expect($result)->toBe(1);
});

afterEach(function () {
    Mockery::close();
});
?>