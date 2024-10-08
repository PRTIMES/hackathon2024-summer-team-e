<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Route;

Route::post("/signup",        [Auth\SignUpController::class, "sendToken"]);
Route::post("/signup/verify", [Auth\SignUpController::class, "register"]);

Route::post("/signin",        [Auth\SignInController::class, "sendToken"]);
Route::post("/signin/verify", [Auth\SignInController::class, "verify"]);

Route::middleware("auth:sanctum")->group(function () {

    Route::get("/press-release/recommend", PressRelease\RecommendController::class);
    Route::get("/press-release/company",   PressRelease\CompanyController::class);

    Route::get("/company/list", Company\ListController::class);
});