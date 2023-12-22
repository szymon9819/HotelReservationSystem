<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function (): void {
    /**
     * hotel
     */
    require base_path('routes/api/v1/hotels.php');

    /**
     * reservation
     */
    require base_path('routes/api/v1/reservations.php');

    /**
     * room cart
     */
    require base_path('routes/api/v1/room_cart.php');
});
