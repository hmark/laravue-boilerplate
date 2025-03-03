<?php

namespace App\Actions;

use App\Http\Resources\MeResource;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\ActionRequestValidation;
use Illuminate\Support\Facades\Auth;
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
        return Auth::guest();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function asController(ActionRequest $request): MeResource
    {
        return $this->handle(...array_values($request->validated()));
    }

    public function handle(string $name, string $email, string $password): MeResource
    {
        $user = $this->userService->create($name, $email, $password);

        $this->authService->login($user);

        return new MeResource(true, $user->name, false, null);
    }
}
