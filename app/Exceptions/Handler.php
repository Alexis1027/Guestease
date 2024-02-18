<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Handle 404 Not Found errors
        if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
            return Inertia::render('Errors/NotFound')->toResponse($request);
        }
        elseif ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return Inertia::render('Errors/Unauthorized')->toResponse($request);
        }
        elseif ($exception instanceof HttpException && $exception->getStatusCode() == 405) {
            return Inertia::render('Errors/SomethingWrong')->toResponse($request);
        }
        // else {
        //     return Inertia::render('Errors/SomethingWrong')->toResponse($request);
        // }
        // Handle other exceptions
        return parent::render($request, $exception);
    }
    
}
