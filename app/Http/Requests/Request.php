<?php

namespace App\Http\Requests;

use App\Enums\Error;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new AppException(Error::InvalidInput(), $errors);
    }
}
