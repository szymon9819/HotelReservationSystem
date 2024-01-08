<?php

declare(strict_types=1);

namespace App\Services\Reservations;

use App\Enums\PaymentStatus;
use App\Exceptions\Payment\PaymentEventNotFoundException;
use App\Messaging\Entities\ReservationCreated;
use App\Messaging\Producers\FailedPaymentProducer;
use App\Messaging\Producers\SuccessfulPaymentProducer;
use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\Payments\PaymentProcessingService;

readonly class ReservationCreatedService
{
    public function __construct(
        private PaymentProcessingService $paymentProcessingService,
        private SuccessfulPaymentProducer $successfulPaymentProducer,
        private FailedPaymentProducer $failedPaymentProducer,
        private PaymentRepositoryInterface $repository,
    ) {
    }

    public function createPayment(ReservationCreated $reservationCreated): Payment
    {
        $payment = $this->repository->createPendingByReservationCreated($reservationCreated);

        $payment = $this->paymentProcessingService->processPayment($payment);

        $this->emitEvent($payment);

        return $payment;
    }

    private function emitEvent(Payment $payment): void
    {
        match($payment->getStatus()) {
            PaymentStatus::COMPLETED => $this->successfulPaymentProducer->publishMessage($payment),
            PaymentStatus::FAILED => $this->failedPaymentProducer->publishMessage($payment),
            PaymentStatus::PENDING => throw new PaymentEventNotFoundException(),
        };
    }
}
