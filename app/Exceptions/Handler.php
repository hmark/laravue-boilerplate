<?php

namespace App\Exceptions;

use App\Enums\Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->renderable(function (AppException $e) {
            if ($e->type === Error::InvalidInput) {
                return response()->json(Error::response(Error::InvalidInput, $e->data[array_keys($e->data)[0]][0]), 400);
            } else {
                return response()->json(Error::response(Error::InvalidInput, config('errors.' . $e->type->value)), 400);
            }
        });

        $this->renderable(function (ModelNotFoundException $e) {
            return response()->json(Error::response(Error::ModelNotFound), 400);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json(Error::response(Error::NotFound), $e->getStatusCode());
        });

        $this->renderable(function (HttpException $e) {
            if ($e->getStatusCode() == 403) {
                return response()->json(Error::response(Error::Unauthorized), $e->getStatusCode());
            } else if ($e->getStatusCode() == 503) {
                return response()->view('errors.maintenance', [], 503);
                //return response()->json(Error::response(Error::Maintenance), $e->getStatusCode());
            } else {
                return response()->json(Error::response(Error::HTTPError), $e->getStatusCode());
            }
        });

        $this->reportable(function (Throwable $e) {
            return response()->json(Error::response(Error::ServerError), 500);
        });
    }
}
