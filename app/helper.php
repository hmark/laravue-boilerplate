<?php

use App\Services\ActivityLoggerService;

if (!function_exists('activity')) {
    function activity(): ActivityLoggerService
    {
        return app(ActivityLoggerService::class);
    }
}
