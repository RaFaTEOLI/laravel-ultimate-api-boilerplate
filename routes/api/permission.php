<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Permissions Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::group(["middleware" => ["role:admin"]], function () {
        Route::get("/permissions", [PermissionController::class, 'index'])
            ->name("permissions")
            ->middleware("permission:read-permissions");

        Route::get("/permission/{id}", [PermissionController::class, 'show'])->middleware("permission:read-permissions");

        Route::delete("/permission/{id}", [PermissionController::class, 'index'])->middleware(
            "permission:delete-permissions",
        );
        Route::post("/permissions", [PermissionController::class, 'store'])->middleware("permission:create-permissions");

        Route::put("/permissions/{id}", [PermissionController::class, 'update'])->middleware("permission:update-permissions");
    });
});
