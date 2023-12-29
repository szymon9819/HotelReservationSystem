<?php

declare(strict_types=1);

namespace App\Repositories\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use App\Contracts\Reservation\GetReservationsContract;
use App\Http\Requests\Pagination\PaginationInterface;
use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    public function createFromContractAndRoomId(CreateReservationContract $contract, int $roomId): Reservation;

    public function update(int $reservationId, array $values): void;

    public function getByContract(GetReservationsContract $contract): Collection;

    public function getPaginatedByContract(GetReservationsContract $contract, PaginationInterface $pagination): LengthAwarePaginator;
}
