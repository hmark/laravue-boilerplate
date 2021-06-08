<?php

namespace App\Exceptions;

use App\Enums\Error;
use Illuminate\Auth\Access\AuthorizationException;
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

        $this->renderable(function (AuthorizationException $e) {
            $response = [
                'error' => Error::Unauthorized()->key,
                'message' => config('errors.unauthorized'),
            ];

            return response()->json($response, 401);
        });

        $this->renderable(function (ModelNotFoundException $e) {
            $response = [
                'error' => Error::ModelNotFound()->key,
                'message' => config('errors.model_not_found'),
            ];

            return response()->json($response, 400);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            $response = [
                'error' => Error::NotFound()->key,
                'message' => config('errors.not_found'),
            ];

            return response()->json($response, $e->getStatusCode());
        });

        $this->renderable(function (HttpException $e) {
            $response = [
                'error' => Error::HTTPError()->key,
                'message' => config('errors.http_error'),
            ];

            return response()->json($response, $e->getStatusCode());
        });

        $this->reportable(function (Throwable $e) {
            $response = [
                'error' => Error::ServerError()->key,
                'message' => config('errors.server_error'),
            ];

            return response()->json($response, 500);
        });
    }
}
