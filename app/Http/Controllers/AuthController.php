<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\MeRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $authService->register($request->dto());

        return $this->success();
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $data = $authService->login($request->dto());

        return $this->success($data);
    }

    public function logout(LogoutRequest $request, AuthService $authService)
    {
        $authService->logout();

        return $this->success();
    }

    public function me(MeRequest $request, AuthService $authService)
    {
        $data = $authService->me();

        return $this->success($data);
    }
}
