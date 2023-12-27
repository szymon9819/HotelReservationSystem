<?php

declare(strict_types=1);

namespace App\Repositories\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use App\Contracts\Reservation\GetReservationsContract;
use App\Enums\ReservationStatus;
use App\Http\Requests\Pagination\PaginationInterface;
use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(
        private readonly Reservation $entity
    ) {
    }

    public function createFromContractAndRoomId(CreateReservationContract $contract, int $roomId): Reservation
    {
        /** @var Reservation */
        return $this->entity->query()->create([
            'customer_id' => $contract->getCustomerId(),
            'room_id' => $roomId,
            'start_date' => $contract->getStartData(),
            'end_date' => $contract->getEndData(),
            'status' => ReservationStatus::ACTIVE,
        ]);
    }

    public function getByContract(GetReservationsContract $contract): Collection
    {
        $query = $this->getFilteredQuery($contract);

        return $query->get();
    }

    public function getPaginatedByContract(GetReservationsContract $contract, PaginationInterface $pagination): LengthAwarePaginator
    {
        $query = $this->getFilteredQuery($contract);

        return $query->paginate(
            perPage: $pagination->getLimit(),
            page: $pagination->hasPage() ? $pagination->getPage() : null
        );
    }

    private function getFilteredQuery(GetReservationsContract $contract): Builder
    {
        $query = $this->entity->query()->where('customer_id', $contract->getCustomerId());

        if ($contract->hasStartDate()) {
            $query->whereDate('start_date', $contract->getStartDate());
        }

        if ($contract->hasEndDate()) {
            $query->whereDate('end_date', $contract->getEndDate());
        }

        if ($contract->hasStatus()) {
            $query->where('status', $contract->getStatus());
        }

        return $query;
    }
}
