<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom throttle middleware
        $middleware->api(append: [
            // \App\Http\Middleware\CustomThrottleRequests::class,
            // \App\Http\Middleware\SecurityHeaders::class,
            // \App\Http\Middleware\BlockSensitiveFiles::class
        ]);

        $middleware->web(append: [
            // \Tonysm\TailwindCss\Http\Middleware\AddLinkHeaderForPreloadedAssets::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            // \App\Http\Middleware\CustomThrottleRequests::class,
            // \App\Http\Middleware\SecurityHeaders::class,
            // \App\Http\Middleware\MinifyHtml::class,
            // \App\Http\Middleware\CacheControlMiddleware::class,
            // \App\Http\Middleware\BlockSensitiveFiles::class
        ]);

        // $middleware->web(append: [
        //     \App\Http\Middleware\HandleInertiaRequests::class,
        //     \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        // ]);

        $middleware->encryptCookies(except: [
            // 'isadmin',
            // 'islogin',
            // 'isauth',
            // 'expire_at',
            // 'csrf_token',
            // 'XSRF-TOKEN'
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
