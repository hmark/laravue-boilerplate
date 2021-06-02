<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $authService->register($request->validated());

        return $this->success();
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $authService->login($request->validated());

        return $this->success();
    }

    public function logout(LogoutRequest $request, AuthService $authService)
    {
        $authService->logout();

        return $this->success();
    }
}
