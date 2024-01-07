<?php

declare(strict_types=1);

namespace App\Services;

use App\Messaging\Entities\ReservationCreated;
use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\Payments\PaymentProcessingService;

readonly class ReservationCreatedService
{
    public function __construct(
        private PaymentProcessingService $paymentProcessingService,
        private PaymentRepositoryInterface $repository,
    ) {
    }

    public function createPayment(ReservationCreated $reservationCreated): Payment
    {
        $payment = $this->repository->createPendingByReservationCreated($reservationCreated);

        return $this->paymentProcessingService->processPayment($payment);
    }
}
