<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception) {
        // Check if the request expects a JSON response (typical for API requests)
        if ($request->expectsJson()) {
            $status = 500;
            $message = 'An error occurred';

            if ($exception instanceof HttpException) {
                $status = $exception->getStatusCode();
                $message = $exception->getMessage();
            } elseif ($exception instanceof QueryException) {
                $status = 500;
                $message = 'Database error';
            }

            return response()->json([
                'error' => [
                    'message' => $message,
                    'status' => $status,
                ]
            ], $status);
        }

        // For web requests, render custom error views
        if ($exception instanceof QueryException) {
            // Render custom error view for database connection issues
            return response()->view('errors.error', ['exception' => $exception], 500);
        }

        // Render custom error view for other exceptions
        return response()->view('errors.error', ['exception' => $exception], $exception->getStatusCode());
    }
}