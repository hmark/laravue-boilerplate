<?php

namespace App\Services;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Enums\Error;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected LoginThrottleService $loginThrottleService;
    protected UserService $userService;

    public function __construct(LoginThrottleService $loginThrottleService, UserService $userService)
    {
        $this->loginThrottleService = $loginThrottleService;
        $this->userService = $userService;
    }

    public function register(RegisterDto $dto)
    {
        $user = $this->userService->create($dto);
        Auth::login($user);
    }

    public function login(LoginDto $dto)
    {
        $request = request();

        if ($this->loginThrottleService->hasTooManyLoginAttempts($request)) {
            try {
                return $this->loginThrottleService->sendLockoutResponse($request);
            } catch (ValidationException $exception) {
                throw new AppException(Error::TooManyLogins, $exception->errors());
            }
        }

        if (Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ])) {
            $request->session()->regenerate();
            $this->loginThrottleService->clearLoginAttempts($request);

            return [
                'name' => auth()->user()->name
            ];
        } else {
            $this->loginThrottleService->incrementLoginAttempts($request);

            throw new AppException(Error::InvalidLogin);
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
    }

    public function me()
    {
        return [
            'authenticated' => auth()->check(),
            'name' => auth()->check() ? auth()->user()->name : null,
        ];
    }
}
