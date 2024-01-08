<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Payment;

use App\Contracts\Reservation\CreateReservationContract;
use App\Entities\CartEntity;
use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Messaging\Entities\Payments\Payment;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Services\Payment\PaymentService;
use App\Services\Reservation\ReservationService;
use App\Services\Room\RoomPriceService;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Support\Carbon;
use Tests\Feature\TestCase;

class PaymentServiceTest extends TestCase
{
    public function test_processPayment_SuccessfulPayment(): void
    {
        $reservationRepositoryMock = $this->createMock(ReservationRepositoryInterface::class);
        $reservationRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, ['status' => ReservationStatus::COMPLETED]);

        $payment = new Payment(1, 1, PaymentStatus::COMPLETED);

        $paymentService = new PaymentService($reservationRepositoryMock);

        $paymentService->processPayment($payment);
    }

    public function test_processPayment_FailedPayment(): void
    {
        $reservationRepositoryMock = $this->createMock(ReservationRepositoryInterface::class);
        $reservationRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with(1, ['status' => ReservationStatus::PAYMENT_FAILED]);

        $payment = new Payment(1, 1, PaymentStatus::FAILED);

        $paymentService = new PaymentService($reservationRepositoryMock);

        $paymentService->processPayment($payment);
    }
}
