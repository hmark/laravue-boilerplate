<?php

use App\Actions\GetMe;
use App\Actions\Login;
use App\Actions\Logout;
use App\Actions\Register;
use Illuminate\Support\Facades\Route;

// guest
Route::post('login', Login::class);
Route::post('register', Register::class);

// public
Route::get('me', GetMe::class);

// auth
Route::post('logout', Logout::class);
