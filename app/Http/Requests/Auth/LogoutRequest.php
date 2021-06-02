<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LogoutRequest extends Request
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [];
    }
}
