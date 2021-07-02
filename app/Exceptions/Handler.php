<?php

namespace App\Exceptions;

use Diol\LaravelErrorSender\ErrorSenderInterface;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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


    public function report(Throwable $exception): void
    {
        if (app()->isProduction() && $this->shouldReport($exception)) {
            $this->container->make(ErrorSenderInterface::class)->send($exception);
        }

        parent::report($exception);
    }


    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderHttpException(HttpExceptionInterface $e)
    {
        $this->registerErrorViewPaths();

        $view = "errors::{$e->getStatusCode()}";
        if ($e->getStatusCode() === 404) {
            $view .= '.' . (\Route::is('cc.*') ? 'admin' : 'client');
        }

        if (view()->exists($view)) {
            return response()->view($view, [
                'errors' => new ViewErrorBag,
                'exception' => $e,
            ], $e->getStatusCode(), $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }
}
