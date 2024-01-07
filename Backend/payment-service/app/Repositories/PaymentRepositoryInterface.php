<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\PaymentStatus;
use App\Messaging\Entities\ReservationCreated;
use App\Models\Payment;

interface PaymentRepositoryInterface
{
    public function findById(int $id): Payment;

    public function createPendingByReservationCreated(ReservationCreated $reservationCreated): Payment;

    public function updateStatus(Payment $payment, PaymentStatus $status): Payment;
}
