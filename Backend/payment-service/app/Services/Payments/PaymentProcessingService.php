<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Repositories\PaymentRepositoryInterface;

readonly class PaymentProcessingService implements PaymentProcessingServiceInterface
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
        private RandomNumberGenerator $numberGenerator
    ) {
    }

    public function processPayment(Payment $payment): Payment
    {
        $randomNumber = $this->numberGenerator->generateRandomNumber(1, 10);

        if ($randomNumber <= 8) {
            return $this->repository->updateStatus($payment, PaymentStatus::COMPLETED);
        }

        return $this->repository->updateStatus($payment, PaymentStatus::FAILED);
    }
}
