<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {

    Route::get("/press-release/redirect/{company_id}/{release_id}", PressRelease\RedirectController::class)->name("press-release.redirect");
});