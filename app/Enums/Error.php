<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Error extends Enum
{
    public const InvalidInput = 'invalid_input';
    public const InvalidLogin = 'invalid_login';
    public const ModelNotFound = 'model_not_found';
    public const TooManyLogins = 'too_many_logins';
}
