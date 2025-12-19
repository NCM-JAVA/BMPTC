<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        /* =============================
         | 400 – Bad Request
         =============================*/
        $this->renderable(function (HttpException $e, $request) {

            $status = $e->getStatusCode();

            if (!in_array($status, [400, 403])) {
                return null;
            }

            Log::warning("HTTP {$status} error", [
                'message' => $e->getMessage(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage() ?: 'Bad request',
                ], $status);
            }

            return response()->view("errors.$status", [], $status);
        });

        /* =============================
         | 404 – Not Found
         =============================*/
        $this->renderable(function (NotFoundHttpException $e, $request) {

            Log::notice('404 Not Found', [
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resource not found',
                ], 404);
            }

            return response()->view('errors.404', ['message' => 'The requested page does not exist.'], 404);
        });

        /* =============================
         | 405 – Method Not Allowed
         =============================*/
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {

            Log::notice('405 Method Not Allowed', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
            ]);

            $message = 'Invalid request method. Please check the request type.';

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ], 405);
            }

            return redirect()->back()
                ->with('error', $message);
        });

        /* =============================
         | 422 – Validation
         =============================*/
        $this->renderable(function (ValidationException $e, $request) {

            Log::warning('Validation error', [
                'errors' => $e->errors(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        });

        /* =============================
         | 500 – Database Errors
         =============================*/
        $this->renderable(function (QueryException $e, $request) {

            Log::error('Database error', [
                'message' => $e->getMessage(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Database error occurred',
                ], 500);
            }

            return response()->view('errors.500', [], 500);
        });

        /* =============================
         | 500 – Catch All
         =============================*/
        $this->renderable(function (Throwable $e, $request) {

            Log::critical('Unhandled exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->fullUrl(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Internal server error',
                ], 500);
            }

            return response()->view('errors.500', [], 500);
        });
    }
}
