<?php

namespace App\Services;

use App\Enums\ActivityType;
use App\Enums\Error;
use App\Exceptions\AppException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected LoginThrottleService $loginThrottleService;

    public function __construct(LoginThrottleService $loginThrottleService)
    {
        $this->loginThrottleService = $loginThrottleService;
    }

    public function login(User $user): void
    {
        Auth::login($user);
    }

    public function loginWithCredentials(string $email, string $password): void
    {
        $request = request();

        if ($this->loginThrottleService->hasTooManyLoginAttempts($request)) {
            try {
                $this->loginThrottleService->sendLockoutResponse($request);
            } catch (ValidationException $exception) {
                throw new AppException(Error::TooManyLogins, $exception->errors());
            }
        }

        if (Auth::attempt([
            'email' => $email,
            'password' => $password,
        ])) {
            $request->session()->regenerate();
            $this->loginThrottleService->clearLoginAttempts($request);

            activity()->by(auth()->user())->log(ActivityType::Login);
        } else {
            $this->loginThrottleService->incrementLoginAttempts($request);

            throw new AppException(Error::InvalidLogin);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        Auth::logout();
        request()->session()->invalidate();
        activity()->by($user)->log(ActivityType::Logout);
    }

    public function validateUserPassword(User $user, string $password)
    {
        if (Hash::check($password, $user->password)) {
            return true;
        }

        throw new AppException(Error::InvalidPassword);
    }
}
