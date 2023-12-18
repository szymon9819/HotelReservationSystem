<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function (): void {
    /**
     * hotel
     */
    require base_path('routes/api/v1/hotels.php');
});
