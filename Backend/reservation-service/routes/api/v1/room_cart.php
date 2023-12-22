<?php

declare(strict_types=1);

use App\Http\Controllers\V1\RoomCart\AddToCartController;
use App\Http\Controllers\V1\RoomCart\ClearCartController;
use App\Http\Controllers\V1\RoomCart\GetCartController;
use App\Http\Controllers\V1\RoomCart\RemoveFromCartController;
use Illuminate\Support\Facades\Route;

Route::prefix('room-cart')->name('room_cart.')->group(function (): void {
    Route::get('/', [GetCartController::class, '__invoke'])->name('get');
    Route::post('/add', AddToCartController::class)->name('add_item');
    Route::delete('/remove-item', [RemoveFromCartController::class, '__invoke'])->name('remove_item');
    Route::delete('/clear', ClearCartController::class)->name('clear');
});
