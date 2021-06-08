<?php

namespace App\Services;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(RegisterDto $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }
}
