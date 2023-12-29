<?php

declare(strict_types=1);

namespace App\Services\Room;

use App\Models\Reservation;

class RoomPriceService
{
    public function getPriceForReservation(Reservation $reservation): float
    {
        return $reservation->getNumberOfDays() * $reservation->room->price_per_night;
    }
}
