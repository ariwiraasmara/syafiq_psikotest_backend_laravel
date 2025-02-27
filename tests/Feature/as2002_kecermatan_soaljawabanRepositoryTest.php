<?php

use App\Repositories\as2002_kecermatan_soaljawabanRepository;
use App\Models\as2002_kecermatan_soaljawaban;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->model = Mockery::mock(as2002_kecermatan_soaljawaban::class);
    $this->repository = new as2002_kecermatan_soaljawabanRepository($this->model);
});

test('all method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->orderBy->paginate->toArray')->andReturn(['data' => 'test']);

    $result = $this->repository->all(1);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('data', 'test');
});

test('all50 method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->orderBy->limit->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->all50(1);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('allData method returns collection when data exists', function () {
    $this->model->shouldReceive('first')->andReturn(true);
    $this->model->shouldReceive('orderBy->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->allData();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('allForTes method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->orderBy->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->allForTes(1);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('get method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->get(1);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('store method returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);

    $result = $this->repository->store(['id2001' => 1, 'soal_jawaban' => 'test']);

    expect($result)->toBe(1);
});

test('update method returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);

    $result = $this->repository->update(1, ['soal_jawaban' => 'updated']);

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