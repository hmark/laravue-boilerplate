<?php

namespace App\Dtos\Auth;

final class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember
    ){}
}
