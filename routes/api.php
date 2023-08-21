<?php

use App\Actions\LoginCookie;
use App\Actions\LogoutCookie;
use App\Actions\GetMe;
use App\Actions\Register;
use App\Actions\LoginToken;
use App\Actions\LogoutToken;
use Illuminate\Support\Facades\Route;

// guest
Route::post('login/cookie', LoginCookie::class);
Route::post('login/token', LoginToken::class);
Route::post('register', Register::class);

// public
Route::get('me', GetMe::class);

// auth
Route::post('logout/cookie', LogoutCookie::class);
Route::post('logout/token', LogoutToken::class);
