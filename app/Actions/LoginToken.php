<?php

namespace App\Actions;

use App\Http\Resources\MeResource;
use App\Services\AuthService;
use App\Traits\ActionRequestValidation;
use Illuminate\Support\Facades\Auth;
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
        return Auth::guest();
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

        $name = Auth::user()->name;
        $isAdmin = Auth::user()->is_admin;

        return (new MeResource(true, $name, $isAdmin, $token));
    }
}
