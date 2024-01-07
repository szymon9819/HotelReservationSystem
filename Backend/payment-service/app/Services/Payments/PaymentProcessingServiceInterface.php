<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Payment;

interface PaymentProcessingServiceInterface
{
    public function processPayment(Payment $payment): Payment;
}
