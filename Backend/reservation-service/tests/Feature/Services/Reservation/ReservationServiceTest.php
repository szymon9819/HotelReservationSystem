<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use App\Entities\CartEntity;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Services\Reservation\ReservationService;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Support\Carbon;
use Tests\Feature\TestCase;

class ReservationServiceTest extends TestCase
{
    public function test_createReservationsByContract_successfully(): void
    {
        $customerId = 1;
        $cartService = $this->createMock(RoomCartServiceInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $service = new ReservationService($cartService, $reservationRepository);

        $cartService->expects($this->once())->method('getCartEntity')->with(1)->willReturn(
            $this->mockCartItem($customerId)
        );

        $cartService->expects($this->once())->method('clearCart')->with(1);
        $cartService->expects($this->once())->method('hasSelectedRooms')->with(1)->willReturn(true);
        $reservationRepository->expects(
            $this->exactly(
                count(
                    $this->mockCartItem($customerId)->toArray()
                ) + 1
            )
        )->method('createFromContractAndRoomId');


        $contract = new class () implements CreateReservationContract {
            public function getCustomerId(): int
            {
                return 1;
            }

            public function getStartData(): Carbon
            {
                return Carbon::parse('2023-01-01');
            }

            public function getEndData(): Carbon
            {
                return Carbon::parse('2023-01-02');
            }
        };

        $service->createReservationsByContract($contract);
    }

    private function mockCartItem(int $customerId): CartEntity
    {
        return new CartEntity(
            $customerId,
            [
                '1' => 1,
                '2' => 1,
                '3' => 1,
            ]
        );
    }
}
