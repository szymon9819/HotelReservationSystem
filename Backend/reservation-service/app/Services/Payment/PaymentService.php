<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Messaging\Entities\Payments\Payment;
use App\Repositories\Reservation\ReservationRepositoryInterface;

readonly class PaymentService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function processPayment(Payment $payment): void
    {
        $status = match ($payment->getStatus()) {
            PaymentStatus::FAILED => ReservationStatus::PAYMENT_FAILED,
            PaymentStatus::COMPLETED => ReservationStatus::COMPLETED,
        };

        $this->reservationRepository->update($payment->getReservationId(), [
            'status' => $status,
        ]);
    }
}
