<?php

namespace App\Services;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Enums\Error;
use App\Exceptions\AppException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    use ThrottlesLogins;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
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

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            try {
                return $this->sendLockoutResponse($request);
            } catch (ValidationException $exception) {
                throw new AppException(Error::TooManyLogins(), $exception->errors());
            }
        }

        if (Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ], $dto->remember)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
        } else {
            $this->incrementLoginAttempts($request);

            throw new AppException(Error::InvalidLogin());
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
    }

    // used only in hasTooManyLoginAttempts
    private function username()
    {
        return 'name';
    }
}
