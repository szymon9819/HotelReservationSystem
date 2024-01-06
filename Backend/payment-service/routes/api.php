<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/**
 * Version 1
 */
Route::prefix('api')->name('api.')->group(function (): void {
    require base_path('routes/api/v1/api.php');
});
