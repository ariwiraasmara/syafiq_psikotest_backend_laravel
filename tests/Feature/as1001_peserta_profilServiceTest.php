<?php
use App\Services\as1001_peserta_profilService;
use App\Repositories\as1001_peserta_profilRepository;
use App\Repositories\as1002_peserta_hasilnilai_teskecermatanRepository;
use Illuminate\Support\Collection;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->repo1 = Mockery::mock(as1001_peserta_profilRepository::class);
    $this->repo2 = Mockery::mock(as1002_peserta_hasilnilai_teskecermatanRepository::class);
    $this->service = new as1001_peserta_profilService($this->repo1, $this->repo2);
});

test('allProfil() returns data correctly', function () {
    $this->repo1->shouldReceive('all')->andReturn(collect(['data' => 'test']));
    $result = $this->service->allProfil('nama', 'asc', null);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('allLatest() returns data correctly', function () {
    $this->repo1->shouldReceive('allLatest')->andReturn(collect(['data' => 'latest']));
    $result = $this->service->allLatest();
    expect($result)->toBeInstanceOf(Collection::class);
});

test('get() returns data correctly', function () {
    $this->repo1->shouldReceive('get')->with(['id' => '1'])->andReturn(collect(['id' => 1]));
    $result = $this->service->get('1');
    expect($result)->toBeInstanceOf(Collection::class);
});

test('store() saves data correctly', function () {
    $this->repo1->shouldReceive('get')->andReturn(null);
    $this->repo1->shouldReceive('store')->andReturn(1);
    $result = $this->service->store(['nama' => 'Test', 'no_identitas' => '123', 'email' => 'test@example.com', 'tgl_lahir' => '2000-01-01', 'asal' => 'Test']);
    expect($result)->toBe(1);
});

test('update() modifies data correctly', function () {
    $this->repo1->shouldReceive('update')->andReturn(1);
    $result = $this->service->update(1, ['email' => 'test@example.com', 'tgl_lahir' => '2000-01-01', 'asal' => 'Test']);
    expect($result)->toBe(1);
});

test('setUpPesertaTes() handles existing data correctly', function () {
    $this->repo1->shouldReceive('get')->andReturn(collect([['id' => 1, 'email' => 'test@example.com', 'tgl_lahir' => '2000-01-01', 'asal' => 'Test']]));
    $this->repo2->shouldReceive('getCheckTesDate')->andReturn(null);
    $result = $this->service->setUpPesertaTes(['no_identitas' => '123', 'email' => 'test@example.com', 'tgl_lahir' => '2000-01-01', 'asal' => 'Test', 'tgl_tes' => '2023-01-01']);
    expect($result)->toBeInstanceOf(Collection::class);
});

test('delete() removes data correctly', function () {
    $this->repo1->shouldReceive('delete')->andReturn(1);
    $result = $this->service->delete(1);
    expect($result)->toBe(1);
});

afterEach(function () {
    Mockery::close();
});