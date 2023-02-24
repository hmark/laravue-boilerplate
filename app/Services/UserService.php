<?php

namespace App\Services;

use App\Enums\ActivityType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(string $name, string $email, string $password): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        activity()->by($user)->log(ActivityType::Register);

        return $user;
    }
}
