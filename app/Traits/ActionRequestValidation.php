<?php

namespace App\Traits;

use App\Enums\Error;
use App\Exceptions\AppException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait ActionRequestValidation
{
    public function getValidationData()
    {
        return array_merge(request()->all(), request()->route()->parameters());
    }

    public function getValidationFailure(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new AppException(Error::InvalidInput, $errors);
    }
}
