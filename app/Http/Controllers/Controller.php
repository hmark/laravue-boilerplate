<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function error(AppError $type, $data = [])
    {
        throw new AppException($type, $data);
    }

    protected function success($data = [])
    {
        if (empty($data)) {
            $data = new stdClass();
        }

        return response()->json($data);
    }
}
