<?php

namespace App\Actions;

use App\Http\Resources\MeResource;
use App\Services\AuthService;
use App\Traits\ActionRequestValidation;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginCookie
{
    use AsAction, ActionRequestValidation;

    public function __construct(protected AuthService $authService)
    {
    }

    public function authorize()
    {
        return auth()->guest();
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function asController(ActionRequest $request): MeResource
    {
        return $this->handle(...array_values($request->validated()));
    }

    public function handle(string $email, string $password): MeResource
    {
        $this->authService->loginCookieWithCredentials($email, $password);

        $name = auth()->user()->name;
        $isAdmin = auth()->user()->is_admin;

        return new MeResource(true, $name, $isAdmin, null);
    }
}
