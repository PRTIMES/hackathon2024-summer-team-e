<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

Route::post("/signup",        [Auth\SignUpController::class, "sendToken"]);
Route::post("/signup/verify", [Auth\SignUpController::class, "register"]);

Route::post("/signin",        [Auth\SignInController::class, "sendToken"]);
Route::post("/signin/verify", [Auth\SignInController::class, "verify"]);