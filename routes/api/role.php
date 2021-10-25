<?php

use App\Http\Controllers\RolesController;
use App\Http\Controllers\RolesPermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/roles", [RolesController::class ,'index']);
        Route::get("/role/{id}", [RolesController::class ,'show']);
        Route::delete("/role/{id}", [RolesController::class ,'destroy']);
        Route::post("/roles", [RolesController::class ,'store']);
        Route::put("/roles/{id}", [RolesController::class ,'update']);
        Route::patch("/roles/{roleId}/permission/{permissionId}", [RolesPermissionController::class ,'store']);
        Route::delete("/roles/{roleId}/permission/{permissionId}", [RolesPermissionController::class ,'destroy']);
    });
});
