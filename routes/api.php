<?php

use App\Actions\User\GetMe;
use App\Actions\User\Logout;
use Illuminate\Support\Facades\Route;

// guest
Route::post('login', Login::class);
Route::post('register', Register::class);
Route::get('me', GetMe::class);

// auth
Route::post('logout', Logout::class);
