<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Error extends Enum
{
    public const HTTPError = 'http_error';
    public const InvalidInput = 'invalid_input';
    public const InvalidLogin = 'invalid_login';
    public const ModelNotFound = 'model_not_found';
    public const NotFound = 'not_found';
    public const ServerError = 'server_error';
    public const TooManyLogins = 'too_many_logins';
    public const Unauthorized = 'unauthorized';
}
