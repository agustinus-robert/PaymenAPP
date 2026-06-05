<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        // Kalau request API (expectsJson) atau route api
        if ($request->expectsJson()) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, Anda tidak memiliki hak untuk mengakses tautan tersebut!'
                ], 403);
            }

            if ($e instanceof TokenMismatchException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi telah kadaluarsa, muat ulang halaman ini dan lakukan proses kembali!'
                ], 419);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum login atau token tidak valid.'
                ], 401);
            }

            // fallback JSON untuk error lain
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
        }

        // request web biasa
        return match (true) {
            $e instanceof AuthorizationException => $this->redirect($request, 'Maaf, Anda tidak memiliki hak untuk mengakses tautan tersebut!'),
            $e instanceof TokenMismatchException => $this->redirect($request, 'Sesi telah kadaluarsa, muat ulang halaman ini dan silakan lakukan proses kembali!'),
            default => parent::render($request, $e)
        };
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // fallback untuk auth exception
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login atau token tidak valid.'
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    public function redirect($request, $message)
    {
        return url()->previous() != $request->url()
            ? redirect()->back()->with('danger', $message)
            : abort(403, 'Unauthorized action.');
    }

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
