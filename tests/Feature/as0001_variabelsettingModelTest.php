<?php

use App\Models\as0001_variabelsetting;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $model = new as0001_variabelsetting();
    expect($model->getFillable())->toBe([
        'variabel',
        'values',
        'created_at',
        'updated_at',
    ]);
});

test('model has expected table name', function () {
    $model = new as0001_variabelsetting();
    expect($model->getTable())->toBe('as0001_variabelsetting');
});

test('model uses timestamps', function () {
    $model = new as0001_variabelsetting();
    expect($model->timestamps)->toBeTrue();
    expect($model::CREATED_AT)->toBe('created_at');
    expect($model::UPDATED_AT)->toBe('updated_at');
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'variabel',
        'values',
        'created_at',
        'updated_at'
    ];
    expect(Schema::hasColumns('as0001_variabelsetting', $columns))->toBeTrue();
});

afterEach(function () {
    Mockery::close();
});