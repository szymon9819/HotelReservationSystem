<?php

declare(strict_types=1);

namespace App\Providers\Repositories;

use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class ReservationRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }
}
