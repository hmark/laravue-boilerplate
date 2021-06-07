<?php

namespace App\Exceptions;

use App\Enums\Error;
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
        $this->renderable(function (AppException $e, $request) {
            if ($e->type->is(Error::InvalidInput())) {
                $response = [
                    'error' => $e->type->key,
                    'message' => $e->data[array_keys($e->data)[0]][0],
                ];
            } else {
                $response = [
                    'error' => $e->type->key,
                    'message' => config('errors.' . $e->type->value),
                ];
            }

            return response()->json($response, 400);
        });
    }
}
