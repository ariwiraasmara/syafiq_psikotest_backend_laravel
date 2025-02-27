<?php
// 
// 
// 
use App\Services\as2002_kecermatan_soaljawabanService;
use App\Repositories\as2001_kecermatan_kolompertanyaanRepository;
use App\Repositories\as2002_kecermatan_soaljawabanRepository;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->repo1 = Mockery::mock(as2001_kecermatan_kolompertanyaanRepository::class);
    $this->repo2 = Mockery::mock(as2002_kecermatan_soaljawabanRepository::class);
    $this->service = new as2002_kecermatan_soaljawabanService($this->repo1, $this->repo2);
});

test('json() returns unique soal data', function () {
    $this->repo2->shouldReceive('all')->with(1)->andReturn(collect([
        (object)['soal_jawaban' => ['soal' => ['Question 1'], 'jawaban' => 'Answer 1']],
        (object)['soal_jawaban' => ['soal' => ['Question 1'], 'jawaban' => 'Answer 1']],
    ]));

    $result = $this->service->json();
    expect($result)->toBeArray()->toHaveCount(1);
});

test('all() returns combined data', function () {
    $this->repo1->shouldReceive('get')->with(1)->andReturn(collect(['pertanyaan' => 'Question']));
    $this->repo2->shouldReceive('all')->with(1)->andReturn(collect(['soaljawaban' => 'Answer']));

    $result = $this->service->all(1);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('allData() returns all data', function () {
    $this->repo2->shouldReceive('allData')->andReturn(collect(['data' => 'test']));

    $result = $this->service->allData();
    expect($result)->toBeInstanceOf(Collection::class);
});

test('allForTes() returns data for test', function () {
    $this->repo2->shouldReceive('allForTes')->with(1)->andReturn(collect(['data' => 'test']));

    $result = $this->service->allForTes(1);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('get() returns soal and jawaban', function () {
    $this->repo1->shouldReceive('get')->with('kolom')->andReturn(collect([['id' => 1]]));
    $this->repo2->shouldReceive('all50')->with(1)->andReturn(collect([
        (object)['soal_jawaban' => ['soal' => ['Question 1'], 'jawaban' => 'Answer 1']],
    ]));

    $result = $this->service->get('kolom');
    expect($result)->toBeInstanceOf(Collection::class);
});

test('store() saves data correctly', function () {
    $this->repo2->shouldReceive('store')->andReturn(1);
    $this->repo1->shouldReceive('get')->andReturn(collect([['kolom_x' => 'X']]));

    $result = $this->service->store(1, ['soal_jawaban' => 'test']);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('update() modifies data correctly', function () {
    $this->repo2->shouldReceive('update')->andReturn(1);
    $this->repo1->shouldReceive('get')->andReturn(collect([['kolom_x' => 'X']]));

    $result = $this->service->update(1, 2, ['soal_jawaban' => 'test']);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('delete() removes data correctly', function () {
    $this->repo2->shouldReceive('delete')->andReturn(1);
    $this->repo1->shouldReceive('get')->andReturn(collect([['kolom_x' => 'X']]));

    $result = $this->service->delete(1, 2);
    expect($result)->toBeInstanceOf(Collection::class);
});

afterEach(function () {
    Mockery::close();
});