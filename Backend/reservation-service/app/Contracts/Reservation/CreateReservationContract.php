<?php

declare(strict_types=1);

namespace App\Contracts\Reservation;

use Illuminate\Support\Carbon;

interface CreateReservationContract
{
    public function getCustomerId(): int;

    public function getStartData(): Carbon;

    public function getEndData(): Carbon;
}
