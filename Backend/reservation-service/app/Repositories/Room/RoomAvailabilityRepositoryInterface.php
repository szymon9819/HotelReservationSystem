<?php

declare(strict_types=1);

namespace App\Repositories\Room;

use App\Contracts\Room\AvailabilityContract;

interface RoomAvailabilityRepositoryInterface
{
    public function checkRoomAvailabilityByContract(AvailabilityContract $contract): bool;
}
