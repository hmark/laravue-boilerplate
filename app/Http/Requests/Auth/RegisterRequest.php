<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function authorize()
    {
        return auth()->guest();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}