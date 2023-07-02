<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCRUDController;
use App\Http\Controllers\Player\PlayerAuthController;
use App\Http\Controllers\Player\PlayerItemController;

/***
 * List route for admin
 */
Route::prefix('admin')->group(function (){

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/get-all-users', [AdminCRUDController::class, 'index']);
        Route::get('/get-user-info/{userId}',[AdminCRUDController::class,'userInfo']);
        Route::put('/update-user/{userId}',[AdminCRUDController::class,'updateUser']);
        Route::delete('/delete-user/{userId}',[AdminCRUDController::class,'deleteUser']);

    });

    Route::post('/login', [AdminAuthController::class, 'login']);
});

/***
 * List route for player
 */
Route::prefix('player')->group(function (){
    Route::post('/register',[PlayerAuthController::class,'register']);
    Route::post('/login',[PlayerAuthController::class,'login']);

    Route::get('/get-all-item-raw',[PlayerItemController::class,'getAllItemRaw']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/refresh', [PlayerAuthController::class, 'refresh']);
        Route::post('/logout', [PlayerAuthController::class, 'logout']);
        Route::get('/get-all-item',[PlayerItemController::class,'getAllItemUser']);
        Route::put('/update-status-item',[PlayerItemController::class,'updateStatusItem']);
        Route::put('/upgrade-item',[PlayerItemController::class,'upgradeItem']);
    });
});
