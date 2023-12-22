<?php

declare(strict_types=1);

namespace App\Repositories\Room;

use App\Contracts\Room\AvailabilityContract;
use App\Models\Reservation;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(
        private readonly Reservation $entity
    ) {
    }

    public function checkRoomAvailabilityByContract(AvailabilityContract $contract): bool
    {
        $existingReservations = $this->entity->query()->where('room_id', $contract->getRoomId())->where(
            function ($query) use ($contract): void {
                $query->whereBetween(
                    'start_date',
                    [$contract->getStartData(), $contract->getEndData()]
                )->orWhereBetween('end_date', [$contract->getStartData(), $contract->getEndData()])->orWhere(
                    function ($query) use ($contract): void {
                        $query->where('start_date', '<=', $contract->getStartData())->where(
                            'end_date',
                            '>=',
                            $contract->getEndData()
                        );
                    }
                );
            }
        )->count();

        return $existingReservations === 0;
    }
}
