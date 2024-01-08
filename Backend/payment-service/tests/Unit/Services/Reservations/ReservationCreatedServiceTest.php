<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Reservations;

use App\Enums\PaymentStatus;
use App\Exceptions\Payment\PaymentEventNotFoundException;
use App\Messaging\Entities\ReservationCreated;
use App\Messaging\Producers\FailedPaymentProducer;
use App\Messaging\Producers\SuccessfulPaymentProducer;
use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\Payments\PaymentProcessingService;
use App\Services\Reservations\ReservationCreatedService;
use Tests\TestCase;

class ReservationCreatedServiceTest extends TestCase
{
    public function testCreatePaymentSuccessfully(): void
    {
        $mockRepository = $this->createMock(PaymentRepositoryInterface::class);
        $mockRepository->method('createPendingByReservationCreated')->willReturn(new Payment());

        $mockPaymentProcessingService = $this->createMock(PaymentProcessingService::class);
        $mockPaymentProcessingService->method('processPayment')->willReturn(new Payment(['status' => PaymentStatus::COMPLETED]));

        $mockSuccessfulPaymentProducer = $this->createMock(SuccessfulPaymentProducer::class);
        $mockSuccessfulPaymentProducer->expects($this->once())->method('publishMessage');

        $reservationCreatedService = new ReservationCreatedService(
            $mockPaymentProcessingService,
            $mockSuccessfulPaymentProducer,
            $this->createMock(FailedPaymentProducer::class),
            $mockRepository
        );

        $reservationCreated = new ReservationCreated(1, 10.0);

        $result = $reservationCreatedService->createPayment($reservationCreated);

        $this->assertInstanceOf(Payment::class, $result);
    }

    public function testCreatePaymentFailed(): void
    {
        $mockRepository = $this->createMock(PaymentRepositoryInterface::class);
        $mockRepository->method('createPendingByReservationCreated')->willReturn(new Payment());

        $mockPaymentProcessingService = $this->createMock(PaymentProcessingService::class);
        $mockPaymentProcessingService->method('processPayment')->willReturn(new Payment(['status' => PaymentStatus::FAILED]));

        $mockFailedPaymentProducer = $this->createMock(FailedPaymentProducer::class);
        $mockFailedPaymentProducer->expects($this->once())->method('publishMessage');

        $reservationCreatedService = new ReservationCreatedService(
            $mockPaymentProcessingService,
            $this->createMock(SuccessfulPaymentProducer::class),
            $mockFailedPaymentProducer,
            $mockRepository
        );

        $reservationCreated = new ReservationCreated(1, 10.0);

        $result = $reservationCreatedService->createPayment($reservationCreated);

        $this->assertInstanceOf(Payment::class, $result);
    }

    public function testEmitEventThrowsExceptionForUnknownStatus(): void
    {
        $mockRepository = $this->createMock(PaymentRepositoryInterface::class);
        $mockPaymentProcessingService = $this->createMock(PaymentProcessingService::class);
        $mockPaymentProcessingService->method('processPayment')->willReturn(new Payment(['status' => PaymentStatus::PENDING]));
        $mockSuccessfulPaymentProducer = $this->createMock(SuccessfulPaymentProducer::class);
        $mockFailedPaymentProducer = $this->createMock(FailedPaymentProducer::class);

        $reservationCreatedService = new ReservationCreatedService(
            $mockPaymentProcessingService,
            $mockSuccessfulPaymentProducer,
            $mockFailedPaymentProducer,
            $mockRepository
        );

        $reservationCreated = new ReservationCreated(1, 10.0);

        $this->expectException(PaymentEventNotFoundException::class);

        $reservationCreatedService->createPayment($reservationCreated);
    }
}
