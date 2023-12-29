<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Reservation\CancelController;
use App\Http\Controllers\V1\Reservation\CreateController;
use App\Http\Controllers\V1\Reservation\DeleteController;
use App\Http\Controllers\V1\Reservation\EditController;
use App\Http\Controllers\V1\Reservation\IndexController;
use App\Http\Controllers\V1\Reservation\ShowController;
use Illuminate\Support\Facades\Route;

Route::prefix('reservations')->name('reservations.')->group(function (): void {
    Route::get('/', [IndexController::class, '__invoke'])->name('index');
    Route::post('/', [CreateController::class, '__invoke'])->name('store');
    Route::get('/{reservation}', [ShowController::class, '__invoke'])->name('show');
    Route::put('/{reservation}', [EditController::class, '__invoke'])->name('update');
    Route::delete('/{reservation}', [DeleteController::class, '__invoke'])->name('destroy');
    Route::post('cancel/{reservation}', [CancelController::class, '__invoke'])->name('cancel');
});
