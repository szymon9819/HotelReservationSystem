<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Reservation;

use App\Contracts\Reservation\CreateReservationContract;
use App\Entities\CartEntity;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Services\Reservation\ReservationService;
use App\Services\Room\RoomPriceService;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Support\Carbon;
use Tests\Feature\TestCase;

class ReservationServiceTest extends TestCase
{
    public function test_createReservationsByContract_successfully(): void
    {
        $customerId = 1;

        $cartServiceMock = $this->createMock(RoomCartServiceInterface::class);
        $reservationRepoMock = $this->createMock(ReservationRepositoryInterface::class);
        $roomPriceServiceMock = $this->createMock(RoomPriceService::class);


        $this->app->instance(RoomCartServiceInterface::class, $cartServiceMock);
        $this->app->instance(RoomCartServiceInterface::class, $cartServiceMock);
        $this->app->instance(ReservationRepositoryInterface::class, $reservationRepoMock);
        $this->app->instance(RoomPriceService::class, $roomPriceServiceMock);

        $service = $this->app->make(ReservationService::class);

        $cartServiceMock->expects($this->once())->method('getCartEntity')->with(1)->willReturn(
            $this->mockCartItem($customerId)
        );
        $cartServiceMock->expects($this->once())->method('clearCart')->with(1);
        $cartServiceMock->expects($this->once())->method('hasSelectedRooms')->with(1)->willReturn(true);

        $reservationRepoMock->expects(
            $this->exactly(
                count(
                    $this->mockCartItem($customerId)->toArray()
                ) + 1
            )
        )->method('createFromContractAndRoomId');
        $roomPriceServiceMock->expects(
            $this->exactly(
                count(
                    $this->mockCartItem($customerId)->toArray()
                ) + 1
            )
        )->method('getPriceForReservation')->withAnyParameters()->willReturn(100.0);

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
