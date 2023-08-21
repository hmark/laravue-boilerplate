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

    public function loginCookieWithCredentials(string $email, string $password): void
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

            activity()->by(auth()->user())->log(ActivityType::LoginCookie);
        } else {
            $this->loginThrottleService->incrementLoginAttempts($request);

            throw new AppException(Error::InvalidLogin);
        }
    }

    public function loginTokenWithCredentials(string $email, string $password, string $deviceName): string
    {
        $request = request();

        if ($this->loginThrottleService->hasTooManyLoginAttempts($request)) {
            try {
                $this->loginThrottleService->sendLockoutResponse($request);
            } catch (ValidationException $exception) {
                throw new AppException(Error::TooManyLogins, $exception->errors());
            }
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            $this->loginThrottleService->incrementLoginAttempts($request);
            throw new AppException(Error::InvalidLogin);
        }

        $this->loginThrottleService->clearLoginAttempts($request);
        Auth::onceUsingId([$user->id]);
        activity()->by($user)->log(ActivityType::LoginToken);

        $user->tokens()
            ->where('tokenable_id', '=', $user->id)
            ->where('name', '=', $deviceName)
            ->delete();

        return $user->createToken($deviceName)->plainTextToken;
    }

    public function logoutCookie()
    {
        $user = auth()->user();
        Auth::logout();
        request()->session()->invalidate();
        activity()->by($user)->log(ActivityType::LogoutCookie);
    }

    public function logoutToken()
    {
        $user = auth()->user();
        request()->user()->currentAccessToken()->delete();
        activity()->by($user)->log(ActivityType::LogoutToken);
    }

    public function validateUserPassword(User $user, string $password)
    {
        if (Hash::check($password, $user->password)) {
            return true;
        }

        throw new AppException(Error::InvalidPassword);
    }
}
