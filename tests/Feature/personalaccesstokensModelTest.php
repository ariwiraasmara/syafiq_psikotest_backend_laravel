<?php

use App\Models\PersonalAccessTokens;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $token = new PersonalAccessTokens();
    expect($token->getFillable())->toBe([
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
        'created_at',
        'updated_at',
    ]);
});

test('model has expected table name', function () {
    $token = new PersonalAccessTokens();
    expect($token->getTable())->toBe('personal_access_tokens');
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
        'created_at',
        'updated_at'
    ];
    expect(Schema::hasColumns('personal_access_tokens', $columns))->toBeTrue();
});