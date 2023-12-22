<?php

declare(strict_types=1);

namespace App\Contracts\Reservation;

use App\Enums\ReservationStatus;

interface GetReservationsContract
{
    public function getCustomerId(): int;

    public function getStartDate(): string;

    public function getEndDate(): string;

    public function getStatus(): ReservationStatus;

    public function hasStartDate(): bool;

    public function hasEndDate(): bool;

    public function hasStatus(): bool;
}
