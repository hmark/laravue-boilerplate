<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class MeRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
