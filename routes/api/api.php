<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user()->format();
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::get("/health", [APIController::class, 'health']);
Route::get("/version", [APIController::class, 'version']);
Route::get("/metrics", [APIController::class, 'metrics']);

Route::get("/lang/{locale}", [LocalizationController::class, 'index']);

Route::fallback(function () {
    return response()->json(["error" => "Page Not Found"], 404);
});
