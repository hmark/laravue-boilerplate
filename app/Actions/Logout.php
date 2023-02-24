<?php

namespace App\Actions;

use App\Services\AuthService;
use App\Traits\ActionRequestValidation;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Logout
{
    use AsAction, ActionRequestValidation;

    public function __construct(protected AuthService $authService)
    {
    }

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [];
    }

    public function asController(ActionRequest $request): void
    {
        $this->handle();
    }

    public function handle(): void
    {
        $this->authService->logout();
    }
}
