<?php

declare(strict_types=1);

namespace App\Providers\Repositories;

use App\Repositories\Room\ReservationRepository;
use App\Repositories\Room\ReservationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RoomAvailabilityRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }
}
