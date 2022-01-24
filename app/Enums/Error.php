<?php

namespace App\Enums;

enum Error: string
{
    case HTTPError = 'http_error';
    case InvalidInput = 'invalid_input';
    case InvalidLogin = 'invalid_login';
    case ModelNotFound = 'model_not_found';
    case NotFound = 'not_found';
    case ServerError = 'server_error';
    case TooManyLogins = 'too_many_logins';
    case Unauthorized = 'unauthorized';

    public static function response(self $value, string $message = null): array
    {
        return [
            'error' => $value,
            'message' => is_null($message) ? config('errors.' . $value->value) : $message,
        ];
    }
}
