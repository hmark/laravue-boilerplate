<?php

namespace App\Http\Controllers;

use App\Http\Requests\I18n\GetLanguageRequest;
use App\Http\Requests\I18n\ResetCacheRequest;
use App\Services\I18nService;

class I18nController extends Controller
{
    public function getLanguage(GetLanguageRequest $request, I18nService $i18nService)
    {
        $gzipJsonEncodedStrings = $i18nService->getLanguage($request->getDto());

        header('Content-Type: text/javascript');
        header('Content-Encoding: gzip');
        echo $gzipJsonEncodedStrings;
        exit();
    }

    public function resetCache(ResetCacheRequest $request, I18nService $i18nService)
    {
        $i18nService->resetCache();
    }
}
