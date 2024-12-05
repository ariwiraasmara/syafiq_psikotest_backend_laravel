<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/request-type', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
