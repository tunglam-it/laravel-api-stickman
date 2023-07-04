<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCRUDController;
use App\Http\Controllers\Player\PlayerAuthController;
use App\Http\Controllers\Item\ItemController;

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

    Route::get('/get-all-item-raw',[ItemController::class,'getAllItemRaw']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/refresh', [PlayerAuthController::class, 'refresh']);
        Route::post('/logout', [PlayerAuthController::class, 'logout']);
        Route::put('/change-status-user/{userId}', [PlayerAuthController::class, 'changeStatus']);
        Route::post('/create-item',[ItemController::class,'createNewItem']);
        Route::get('/get-all-item-info',[ItemController::class,'getAllItemInfo']);
        Route::get('/get-all-item',[ItemController::class,'getAllItemUser']);
        Route::get('/get-item-info/{itemId}',[ItemController::class,'getItemInfo']);
        Route::put('/update-item-info/{itemId}',[ItemController::class,'updateItemInfo']);
        Route::put('/update-status-item',[ItemController::class,'updateStatusItem']);
        Route::put('/upgrade-item',[ItemController::class,'upgradeItem']);
        Route::put('/open-chest',[ItemController::class,'openChest']);
        Route::delete('/delete-item/{itemId}',[ItemController::class,'deleteItem']);
    });
});
