<?php

namespace App\Http\Requests\I18n;

use App\Http\Requests\Request;

class GetLanguageRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lang' => 'required',
        ];
    }
}
