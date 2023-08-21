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
            'name' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'required|string',
        ];
    }

    public function asController(ActionRequest $request): MeResource
    {
        return $this->handle(...array_values($request->validated()));
    }

    public function handle(string $name, string $password, string $deviceName): MeResource
    {
        $token = $this->authService->loginTokenWithCredentials($name, $password, $deviceName);

        $isAdmin = auth()->user()->is_admin;

        return (new MeResource(true, $name, $isAdmin, $token));
    }
}
