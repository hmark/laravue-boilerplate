<?php

namespace App\Actions\User;

use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\ActionRequestValidation;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction, ActionRequestValidation;

    public function __construct(
        protected AuthService $authService,
        protected UserService $userService
    ) {
    }

    public function authorize()
    {
        return auth()->guest() && config('k4rally.registration');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function asController(ActionRequest $request): UserResource
    {
        return $this->handle(...array_values($request->validated()));
    }

    public function handle(string $name, string $email, string $password): UserResource
    {
        $user = $this->userService->create($name, $email, $password);

        $this->authService->login($user);

        return new UserResource($user);
    }
}
