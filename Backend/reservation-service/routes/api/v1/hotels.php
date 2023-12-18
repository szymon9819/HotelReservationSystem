<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Hotel\CreateController;
use App\Http\Controllers\V1\Hotel\DeleteController;
use App\Http\Controllers\V1\Hotel\EditController;
use App\Http\Controllers\V1\Hotel\IndexController;
use App\Http\Controllers\V1\Hotel\ShowController;
use Illuminate\Support\Facades\Route;

Route::prefix('hotels')->name('hotels.')->group(function (): void {
    Route::get('/', [IndexController::class, '__invoke'])->name('index');
    Route::post('/', [CreateController::class, '__invoke'])->name('store');
    Route::get('/{id}', [ShowController::class, '__invoke'])->name('show');
    Route::put('/{id}', [EditController::class, '__invoke'])->name('update');
    Route::delete('/{id}', [DeleteController::class, '__invoke'])->name('destroy');
});
