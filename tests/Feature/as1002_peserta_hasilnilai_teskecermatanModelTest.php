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
    $model = new as1002_peserta_hasilnilai_teskecermatan();
    expect($model->getFillable())->toBe([
        // 'id',
        'id1001',
        'tgl_ujian',
        'hasilnilai_kolom_1',
        'hasilnilai_kolom_2',
        'hasilnilai_kolom_3',
        'hasilnilai_kolom_4',
        'hasilnilai_kolom_5',
    ]);
});

test('model has expected table name', function () {
    $model = new as1002_peserta_hasilnilai_teskecermatan();
    expect($model->getTable())->toBe('as1002_peserta_hasilnilai_teskecermatan');
});

test('model does not use timestamps', function () {
    $model = new as1002_peserta_hasilnilai_teskecermatan();
    expect($model->timestamps)->toBeFalse();
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'id1001',
        'tgl_ujian',
        'hasilnilai_kolom_1',
        'hasilnilai_kolom_2',
        'hasilnilai_kolom_3',
        'hasilnilai_kolom_4',
        'hasilnilai_kolom_5',
    ];
    expect(Schema::hasColumns('as1002_peserta_hasilnilai_teskecermatan', $columns))->toBeTrue();
});