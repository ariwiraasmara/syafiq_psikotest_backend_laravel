<?php

use App\Repositories\as1002_peserta_hasilnilai_teskecermatanRepository;
use App\Models\as1002_peserta_hasilnilai_teskecermatan;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->seed();
    $this->model = Mockery::mock(as1002_peserta_hasilnilai_teskecermatan::class);
    $this->repository = new as1002_peserta_hasilnilai_teskecermatanRepository($this->model);
});

test('all method returns collection when data exists', function () {
    $this->model->shouldReceive('where->first')->andReturn(true);
    $this->model->shouldReceive('where->get')->andReturn(collect([['id' => 1]]));

    $result = $this->repository->all(['id1001' => 1]);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('get method returns collection when data exists', function () {
    // $this->model->shouldReceive('where->get')->andReturn(collect(['id' => 1]));

    $result = $this->repository->get(1, '2023-01-01');

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('search method returns collection when data exists', function () {
    $this->model->shouldReceive('whereBetween->get')->andReturn(collect(['id' => 1]));

    $result = $this->repository->search(1, '2023-01-01', '2023-01-31');

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->first())->toHaveKey('id', 1);
});

test('store method returns id when successful', function () {
    $this->model->shouldReceive('create')->andReturn((object)['id' => 1]);

    $result = $this->repository->store(['id1001' => 1, 'tgl_ujian' => '2023-01-01']);

    expect($result)->toBe(1);
});

test('update method returns number of affected rows when successful', function () {
    $this->model->shouldReceive('where->update')->andReturn(1);

    $result = $this->repository->update(1, ['hasilnilai_kolom_1' => 10]);

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