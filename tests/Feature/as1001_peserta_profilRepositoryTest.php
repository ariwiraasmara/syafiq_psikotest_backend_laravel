<?php

use App\Repositories\as1001_peserta_profilRepository;
use App\Models\as1001_peserta_profil;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(as1001_peserta_profil::class);
    $this->repository = new as1001_peserta_profilRepository($this->model);
});

test('all method returns collection when data exists', function () {
    $this->model->shouldReceive('first')->andReturn(true);
    $this->model->shouldReceive('select->orderBy->where->orWhere->paginate->toArray')->andReturn(['data' => 'test']);

    $result = $this->repository->all('nama', 'asc',null);

    expect($result)->toBeArray();
    // expect($result)->toHaveKey('data', 'test');
});

test('allLatest method returns collection when data exists', function () {
    $this->model->shouldReceive('join->first')->andReturn(true);
    $this->model->shouldReceive('distinct->select->join->orderBy->limit->get')->andReturn(collect(['data' => 'test']));

    $result = $this->repository->allLatest();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('data', 'test');
});

test('get method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->get(['id' => 1]);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('store method returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);

    $result = $this->repository->store(['nama' => 'Test User']);

    expect($result)->toBe(1);
});

test('update method returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);

    $result = $this->repository->update(1, ['nama' => 'Updated User']);

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