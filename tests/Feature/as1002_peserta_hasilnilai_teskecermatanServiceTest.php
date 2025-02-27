<?php
// 
// 
// 
use App\Services\as1002_peserta_hasilnilai_teskecermatanService;
use App\Repositories\as1001_peserta_profilRepository;
use App\Repositories\as1002_peserta_hasilnilai_teskecermatanRepository;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->repo1 = Mockery::mock(as1001_peserta_profilRepository::class);
    $this->repo2 = Mockery::mock(as1002_peserta_hasilnilai_teskecermatanRepository::class);
    $this->service = new as1002_peserta_hasilnilai_teskecermatanService($this->repo1, $this->repo2);
});

test('all() returns data correctly', function () {
    $this->repo2->shouldReceive('all')->with(['id1001' => 1])->andReturn(collect(['data' => 'test']));
    $result = $this->service->all(1);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('get() returns data correctly', function () {
    $this->repo1->shouldReceive('get')->with(['no_identitas' => 1])->andReturn(collect([['id' => 1]]));
    $this->repo2->shouldReceive('get')->with(1, '2023-01-01')->andReturn(collect(['result' => 'test']));
    $result = $this->service->get(1, '2023-01-01');
    expect($result)->toBeInstanceOf(Collection::class);
});

test('search() returns data correctly', function () {
    $this->repo1->shouldReceive('get')->with(['id' => 1])->andReturn(collect([['id' => 1]]));
    $this->repo2->shouldReceive('search')->with(1, '2023-01-01', '2023-01-31')->andReturn(collect(['result' => 'test']));
    $result = $this->service->search(1, '2023-01-01', '2023-01-31');
    expect($result)->toBeInstanceOf(Collection::class);
});

test('store() saves data correctly', function () {
    $this->repo2->shouldReceive('store')->andReturn(1);
    $result = $this->service->store(1, [
        'hasilnilai_kolom_1' => 10,
        'hasilnilai_kolom_2' => 20,
        'hasilnilai_kolom_3' => 30,
        'hasilnilai_kolom_4' => 40,
        'hasilnilai_kolom_5' => 50,
    ]);
    expect($result)->toBe(1);
});

test('update() modifies data correctly', function () {
    $this->repo2->shouldReceive('update')->andReturn(1);
    $result = $this->service->update(1, [
        'hasilnilai_kolom_1' => 15,
        'hasilnilai_kolom_2' => 25,
        'hasilnilai_kolom_3' => 35,
        'hasilnilai_kolom_4' => 45,
        'hasilnilai_kolom_5' => 55,
    ]);
    expect($result)->toBe(1);
});

test('delete() removes data correctly', function () {
    $this->repo2->shouldReceive('delete')->andReturn(1);
    $result = $this->service->delete(1);
    expect($result)->toBe(1);
});

afterEach(function () {
    Mockery::close();
});