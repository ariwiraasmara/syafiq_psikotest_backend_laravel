<?php

use App\Models\User;
use App\Models\PersonalAccessTokens;
use Illuminate\Support\Facades\Schema;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('model has expected fillable attributes', function () {
    $user = new User();
    expect($user->getFillable())->toBe(['name', 'email', 'password']);
});

test('model has expected hidden attributes', function () {
    $user = new User();
    expect($user->getHidden())->toBe(['password']);
});

test('table has expected columns', function () {
    $columns = [
        'id',
        'name',
        'email',
        'password',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];
    expect(Schema::hasColumns('users', $columns))->toBeTrue();
});