<?php

namespace App\Services;

use App\Dtos\I18n\GetLanguageDto;
use App\Enums\Language;
use Illuminate\Support\Facades\Cache;

class I18nService
{
    public function getLanguage(GetLanguageDto $dto)
    {
        $lang = $dto->language;

        $gzipJsonEncodedStrings = Cache::rememberForever('i18n.' . $lang . '.js', function () use ($lang) {
            $files = glob(resource_path('lang/' . $lang . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name = basename($file, '.php');

                if ($name == 'admin') {
                    continue;
                }

                $strings[$name] = require $file;
            }

            return gzencode('window.i18n = ' . json_encode($strings) . ';');
        });

        return $gzipJsonEncodedStrings;
    }

    public function resetCache()
    {
        foreach (Language::getKeys() as $lang) {
            Cache::forget('i18n.' . $lang . '.js');
        }

        Cache::forget('i18n.version');
    }

}
