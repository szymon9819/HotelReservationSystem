<?php

declare(strict_types=1);

namespace App\Services\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use App\Contracts\Reservation\GetReservationsContract;
use App\Exceptions\Reservation\ReservationCreationException;
use App\Http\Requests\Pagination\PaginationInterface;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReservationService
{
    public function __construct(
        private readonly RoomCartServiceInterface $cartService,
        private readonly ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function createReservationsByContract(CreateReservationContract $contract): void
    {
        if (!$this->cartService->hasSelectedRooms($contract->getCustomerId())) {
            return;
        }

        $cart = $this->cartService->getCartEntity($contract->getCustomerId());
        try {
            DB::beginTransaction();

            foreach ($cart->getItems() as $roomId) {
                $this->reservationRepository->createFromContractAndRoomId($contract, $roomId);
            }

            $this->cartService->clearCart($contract->getCustomerId());
            DB::commit();
        } catch (Throwable) {
            DB::rollback();

            throw new ReservationCreationException();
        }
    }

    public function getByContract(GetReservationsContract $contract): Collection
    {
        return $this->reservationRepository->getByContract($contract);
    }

    public function getPaginatedByContract(GetReservationsContract $contract, PaginationInterface $pagination): LengthAwarePaginator
    {
        return $this->reservationRepository->getPaginatedByContract($contract, $pagination);
    }
}
