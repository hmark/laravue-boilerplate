<?php

namespace App\Dtos\Auth;

final class RegisterDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ){}
}
