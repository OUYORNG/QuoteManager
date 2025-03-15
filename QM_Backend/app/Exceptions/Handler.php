<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'message' => $e->getMessage(),
                ], 401);
            }
        });

        // Optional: Handle other types of exceptions
        $this->renderable(function (\Exception $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Server Error',
                    'message' => env('APP_DEBUG') ? $e->getMessage() : 'An unexpected error occurred',
                ], 500);
            }
        });
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => $exception->getMessage(),
            ], 401);
        }
        return response()->json(['message'=>'unauthenticated',401]);

        // return redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}