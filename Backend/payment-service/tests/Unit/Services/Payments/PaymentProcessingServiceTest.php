<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Payments;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\Payments\PaymentProcessingService;
use App\Services\Payments\RandomNumberGenerator;
use Tests\TestCase;

class PaymentProcessingServiceTest extends TestCase
{
    public function testProcessPaymentCompletesSuccessfully(): void
    {
        $mockPaymentRepository = $this->createMock(PaymentRepositoryInterface::class);
        $mockNumberGenerator = $this->createMock(RandomNumberGenerator::class);

        $paymentProcessingService = new PaymentProcessingService($mockPaymentRepository, $mockNumberGenerator);

        $payment = new Payment([
            'id' => 1,
            'merchant_id' => 1,
            'reservation_id' => 1,
            'amount' => 100.0,
            'status' => PaymentStatus::PENDING,
        ]);

        $mockNumberGenerator->expects($this->once())->method('generateRandomNumber')->with(1, 10)->willReturn(7);

        $mockPaymentRepository->expects($this->once())->method('updateStatus')->with(
            $payment,
            PaymentStatus::COMPLETED
        )->willReturn($payment);

        $result = $paymentProcessingService->processPayment($payment);

        $this->assertEquals($payment, $result);
    }

    public function testProcessPaymentFails(): void
    {
        $mockPaymentRepository = $this->createMock(PaymentRepositoryInterface::class);
        $mockNumberGenerator = $this->createMock(RandomNumberGenerator::class);

        $paymentProcessingService = new PaymentProcessingService($mockPaymentRepository, $mockNumberGenerator);

        $payment = new Payment([
            'id' => 1,
            'merchant_id' => 1,
            'reservation_id' => 1,
            'amount' => 100.0,
            'status' => PaymentStatus::PENDING,
        ]);

        $mockNumberGenerator->expects($this->once())->method('generateRandomNumber')
            ->with(1, 10)
            ->willReturn(9);

        $mockPaymentRepository->expects($this->once())->method('updateStatus')->with(
            $payment,
            PaymentStatus::FAILED
        )->willReturn($payment);

        $result = $paymentProcessingService->processPayment($payment);

        $this->assertEquals($payment, $result);
    }
}
