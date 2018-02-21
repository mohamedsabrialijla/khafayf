<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
             $code = $exception->getCode();
             $message = $exception->getMessage();
             if (anInstanceOf(UnauthorizedException::class)) {
         $code = 401;
             }
             if ($code == 0 || $code > 500) {
                 $code = 500;
     }
     return mainResponse(false, $message, null, $code, 'error');
         }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return mainResponse(false, 'لم يتم تسجيل الدخول', 'Unauthenticated.', [], 401);
        }

        if (in_array('admin', explode('/', request()->url()))) {
            return redirect('/admin/login');
        } else {
            return redirect('/login');
        }
    }
}
