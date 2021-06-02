<?php

namespace App\Services;

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

    public function register($data)
    {
        $user = $this->userService->create($data);
        Auth::login($user);
    }

    public function login($data)
    {
        $request = request();

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            try {
                return $this->sendLockoutResponse($request);
            } catch (ValidationException $exception) {
                throw new AppException(Error::TooManyLogins(), $exception->errors());
            }
        }

        if (Auth::attempt([
            'name' => $data['name'],
            'password' => $data['password'],
        ], $data['remember'])) {
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
