<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Verify Email Routes
|--------------------------------------------------------------------------
|
*/

Route::post('/forgot-password', [ResetPasswordController::class, 'send'])
    ->name('password.send');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.reset');

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::patch("/reset-password", [ResetPasswordController::class, 'change']);
});
