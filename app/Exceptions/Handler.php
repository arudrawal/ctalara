<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    
    public function render($request, Throwable $e)
    {
        // Exception for API requests converted to JSON.
        /*if ($request->expectsJson()) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getFile() . ': '. $e->getLine() . ': ' . $e->getMessage(),
                'data'   => $e-> getTraceAsString(),
            ], 404);
        }*/
        return parent::render($request, $e);
    }
}
