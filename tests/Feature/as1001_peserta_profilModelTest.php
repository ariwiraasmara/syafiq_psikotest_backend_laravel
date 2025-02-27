<?php

use App\Models\as1001_peserta_profil;
use App\Models\as1002_peserta_hasilnilai_teskecermatan;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $model = new as1001_peserta_profil();
    expect($model->getFillable())->toBe([
        'nama',
        'no_identitas',
        'email',
        'tgl_lahir',
        'usia',
        'asal',
    ]);
});

test('model has expected table name', function () {
    $model = new as1001_peserta_profil();
    expect($model->getTable())->toBe('as1001_peserta_profil');
});

test('model does not use timestamps', function () {
    $model = new as1001_peserta_profil();
    expect($model->timestamps)->toBeFalse();
});

test('model has as1002_peserta_hasilnilai_teskecermatan relationship', function () {
    $model = new as1001_peserta_profil();
    expect($model->as1002_peserta_hasilnilai_teskecermatan())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('table has expected columns', function () {
    $columns = ['id', 'nama', 'no_identitas', 'email', 'tgl_lahir', 'usia', 'asal'];
    expect(Schema::hasColumns('as1001_peserta_profil', $columns))->toBeTrue();
});