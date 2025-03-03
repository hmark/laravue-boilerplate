<?php

namespace App\Actions;

use App\Http\Resources\MeResource;
use App\Traits\ActionRequestValidation;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMe
{
    use AsAction, ActionRequestValidation;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function asController(ActionRequest $request): MeResource
    {
        return $this->handle();
    }

    public function handle(): MeResource
    {
        
        $isAuthenticated = Auth::check();
        $name = Auth::check() ? Auth::user()->name : '';
        $isAdmin = Auth::check() ? Auth::user()->is_admin : false;

        return new MeResource($isAuthenticated, $name, $isAdmin, null);
    }
}
