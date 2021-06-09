<?php

namespace App\Http\Requests\Auth;

use App\Dtos\Auth\LoginDto;
use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function authorize()
    {
        return auth()->guest();
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function getDto(): LoginDto
    {
        $data = $this->validated();

        return new LoginDto(
            $data['email'],
            $data['password'],
        );
    }
}
