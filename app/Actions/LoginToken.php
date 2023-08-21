<?php

namespace App\Actions;

use App\Http\Resources\MeResource;
use App\Services\AuthService;
use App\Traits\ActionRequestValidation;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginToken
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
            'email' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'required|string',
        ];
    }

    public function asController(ActionRequest $request): MeResource
    {
        return $this->handle(...array_values($request->validated()));
    }

    public function handle(string $email, string $password, string $deviceId): MeResource
    {
        $token = $this->authService->loginTokenWithCredentials($email, $password, $deviceId);

        $name = auth()->user()->name;
        $isAdmin = auth()->user()->is_admin;

        return (new MeResource(true, $name, $isAdmin, $token));
    }
}
