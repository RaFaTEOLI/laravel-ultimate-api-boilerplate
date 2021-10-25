<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersRoleController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("users/{id}", [UserController::class, 'show'])->middleware("permission:read-users");

        Route::get("users", [UserController::class, 'index'])->middleware("permission:read-users");

        Route::delete("/user/{id}", [UserController::class, 'destroy'])->middleware("permission:delete-users");

        Route::post("/users", [UserController::class, 'store'])->middleware("permission:create-users");

        Route::put("users/{id}", [UserController::class, 'update'])->middleware("permission:update-users");

        Route::patch("/users/{userId}/role/{roleId}", [UsersRoleController::class, 'store'])->middleware(
            "permission:update-users",
        );
        Route::delete("/users/{userId}/role/{roleId}", [UsersRoleController::class, 'destroy'])->middleware(
            "permission:update-users",
        );
    });
});
