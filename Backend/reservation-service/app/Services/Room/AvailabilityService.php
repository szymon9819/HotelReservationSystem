<?php

declare(strict_types=1);

namespace App\Services\Room;

use App\Contracts\Room\AvailabilityContract;
use App\Repositories\Room\ReservationRepositoryInterface;

class AvailabilityService
{
    public function __construct(
        private readonly RoomLockingServiceInterface $roomLockingService,
        private readonly ReservationRepositoryInterface $roomAvailabilityRepository,
    ) {
    }

    public function isRoomAvailableByContract(AvailabilityContract $contract): bool
    {
        if ($this->roomLockingService->checkRoomLockExists($contract->getRoomId())) {
            return false;
        }

        return $this->roomAvailabilityRepository->checkRoomAvailabilityByContract($contract);
    }
}
