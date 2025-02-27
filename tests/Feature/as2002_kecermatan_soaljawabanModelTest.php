<?php

use App\Models\as2002_kecermatan_soaljawaban;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $model = new as2002_kecermatan_soaljawaban();
    expect($model->getFillable())->toBe([
        // 'id',
        'id2001',
        'soal_jawaban',
        'created_at',
        'updated_at',
    ]);
});

test('model has expected table name', function () {
    $model = new as2002_kecermatan_soaljawaban();
    expect($model->getTable())->toBe('as2002_kecermatan_soaljawaban');
});

test('model does use timestamps', function () {
    $model = new as2002_kecermatan_soaljawaban();
    expect($model->timestamps)->toBeTrue();
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'id2001',
        'soal_jawaban',
        'created_at',
        'updated_at',
    ];
    expect(Schema::hasColumns('as2002_kecermatan_soaljawaban', $columns))->toBeTrue();
});