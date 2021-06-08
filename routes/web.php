<?php

use App\Http\Controllers\I18nController;
use Illuminate\Support\Facades\Route;

Route::get('/js/i18n.{lang}.js', [I18nController::class, 'getLanguage']);
Route::get('/i18n/reset', [I18nController::class, 'resetCache']);

Route::get('/{vue_capture?}', function () {
    return view('dashboard');
})->where('vue_capture', '[\/\w-]*');
