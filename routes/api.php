<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCRUDController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Item\ItemController;

/***
 * List route for admin
 */
Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['jwt.auth', 'checkAdmin']], function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/get-user-info/{userId}', [AdminCRUDController::class, 'userInfo']);
        Route::put('/update-user/{userId}', [AdminCRUDController::class, 'updateUser']);
        Route::put('/update-item-info/{itemId}', [ItemController::class, 'updateItemInfo']);
        Route::delete('/delete-user/{userId}', [AdminCRUDController::class, 'deleteUser']);
        Route::post('/give-item-for-user', [ItemController::class, 'giveItemForUser']);
        Route::post('/create-item', [ItemController::class, 'createNewItem']);
        Route::delete('/delete-item/{itemId}', [ItemController::class, 'deleteItem']);
        Route::delete('/delete-item-user/{itemUserId}', [ItemController::class, 'deleteItemUser']);
    });
    Route::get('/get-all-users', [AdminCRUDController::class, 'index']);
    Route::middleware('checkAdmin')->post('/login', [AdminAuthController::class, 'login']);
});

/***
 * List route for player
 */
Route::prefix('player')->group(function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::get('/get-all-item-raw', [ItemController::class, 'getAllItemRaw']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/refresh', [UserAuthController::class, 'refresh']);
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::put('/change-status-user/{userId}', [UserAuthController::class, 'changeStatus']);
        Route::get('/get-all-item-info', [ItemController::class, 'getAllItemInfo']);
        Route::get('/get-all-item-users', [ItemController::class, 'getAllItemUsers']);
        Route::get('/get-all-item-user-by-id/{userId}', [ItemController::class, 'getAllItemUserById']);
        Route::get('/get-item-info/{itemId}', [ItemController::class, 'getItemInfo']);
        Route::put('/update-status-item', [ItemController::class, 'updateStatusItem']);
        Route::put('/upgrade-item', [ItemController::class, 'upgradeItem']);
        Route::put('/update-user-after-battle', [UserAuthController::class, 'updateUserAfterBattle']);
        Route::put('/open-chest', [ItemController::class, 'openChest']);
    });
});
