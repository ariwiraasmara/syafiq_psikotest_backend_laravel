<?php
// 
// 
// 
use App\Repositories\as0001_variabelsettingRepository;
use App\Services\as0001_variabelsettingService;

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function() {
    $this->seed();
});

test('all() returns data correctly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $expectedData = collect(['test' => 'data']);
    $mockRepo->shouldReceive('all')
            ->once()
            ->with('id', 'asc', null)
            ->andReturn($expectedData);
    $service = new as0001_variabelsettingService($mockRepo);
    $result = $service->all('id', 'asc');
    expect($result)->toEqual($expectedData);
});

test('all() returns data incorrectly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('all')
            ->once()
            ->with('invalid', 'id', null)
            ->andThrow(new Exception('Invalid sort parameter'));
    $service = new as0001_variabelsettingService($mockRepo);
    $result = $service->all('invalid', 'id');
    expect($result)->toBe(-12);
});

test('get() returns data correctly', function () {
    $expectedData = ['id' => 1, 'value' => 'test'];
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('get')
            ->once()
            ->with(['id' => 1])
            ->andReturn($expectedData);
    $service = new as0001_variabelsettingService($mockRepo);
    $result = $service->get(1);
    expect($result)->toEqual($expectedData);
});

test('get() returns data incorrectly', function () {
    $mockRepo = $this->createMock(as0001_variabelsettingRepository::class);
    $mockRepo->expects($this->once())
            ->method('get')
            ->with(['id' => 999])
            ->willThrowException(new Exception('Record not found'));
    $service = new as0001_variabelsettingService($mockRepo);
    $result = $service->get(999);
    expect($result)->toBe(-12);
});

// Store valid variable setting with required fields and return positive ID
test('store() saves data correctly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    
    $expectedData = [
        'variabel' => 'test_var',
        'values' => 'test_value',
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    $mockRepo->shouldReceive('store')
            ->once()
            ->withArgs(function ($data) {
                return $data['variabel'] === 'test_var'
                    && $data['values'] === 'test_value'
                    && $data['created_at'] instanceof \Carbon\Carbon
                    && $data['updated_at'] instanceof \Carbon\Carbon;
            })
            ->andReturn(1);
    
    $service = new as0001_variabelsettingService($mockRepo);
    $inputData = [
        'variabel' => 'test_var',
        'values' => 'test_value'
    ];
    
    $result = $service->store($inputData);
    expect($result)->toBe(1);
});

// Ensure that the store method returns an error when the 'variabel' field is missing.
test('store() saves data incorrectly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('store')->never();
    $service = new as0001_variabelsettingService($mockRepo);
    $result = $service->store([
        'values' => 'test_value'
    ]);
    expect($result)->toBe(-12);
});

// Successfully updates variable setting with valid id and values using Laravel Pest
test('update() modifies data correctly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('update')
        ->once()
        ->withArgs(function ($id, $data) {
            return $id === 1 &&
                   $data['variabel'] === 'test_var' &&
                   $data['values'] === 'test_value' &&
                   $data['updated_at'] instanceof \DateTime;
        })
        ->andReturn(1);

    $service = new as0001_variabelsettingService($mockRepo);

    $result = $service->update(1, [
        'variabel' => 'test_var',
        'values' => 'test_value'
    ]);

    expect($result)->toBe(1);
});

// Test update method returns -12 when 'values' field is missing in the input array.
test('update() modifies data incorrectly', function () {
    $mockRepo = $this->createMock(as0001_variabelsettingRepository::class);
    $mockRepo->expects($this->never())
        ->method('update');
    
    $service = new as0001_variabelsettingService($mockRepo);
    
    $result = $service->update(1, [
        'variabel' => 'test_var'
        // missing 'values' field
    ]);
    
    expect($result)->toBe(-12);
});

// Successfully deletes record when valid ID is provided and returns positive number
test('delete() removes data correctly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('delete')
        ->once()
        ->with(1)
        ->andReturn(1);

    $service = new as0001_variabelsettingService($mockRepo);

    $result = $service->delete(1);

    expect($result)->toBe(1);
});

// Returns zero when an invalid ID is provided to the delete method.
test('delete() removes data incorrectly', function () {
    $mockRepo = Mockery::mock(as0001_variabelsettingRepository::class);
    $mockRepo->shouldReceive('delete')
        ->once()
        ->with(999)
        ->andReturn(0);

    $service = new as0001_variabelsettingService($mockRepo);

    $result = $service->delete(999);

    expect($result)->toBe(0);
});