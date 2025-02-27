<?php

use App\Models\as2001_kecermatan_kolompertanyaan;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $model = new as2001_kecermatan_kolompertanyaan();
    expect($model->getFillable())->toBe([
        // 'id',
        'kolom_x',
        'nilai_A',
        'nilai_B',
        'nilai_C',
        'nilai_D',
        'nilai_E',
        'created_at',
        'updated_at',
    ]);
});

test('model has expected table name', function () {
    $model = new as2001_kecermatan_kolompertanyaan();
    expect($model->getTable())->toBe('as2001_kecermatan_kolompertanyaan');
});

test('model does use timestamps', function () {
    $model = new as2001_kecermatan_kolompertanyaan();
    expect($model->timestamps)->toBeTrue();
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'kolom_x',
        'nilai_A',
        'nilai_B',
        'nilai_C',
        'nilai_D',
        'nilai_E',
        'created_at',
        'updated_at',
    ];
    expect(Schema::hasColumns('as2001_kecermatan_kolompertanyaan', $columns))->toBeTrue();
});