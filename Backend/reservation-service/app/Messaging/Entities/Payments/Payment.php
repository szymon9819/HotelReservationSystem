<?php

declare(strict_types=1);

namespace App\Messaging\Entities\Payments;

use App\Enums\PaymentStatus;

readonly class Payment
{
    public function __construct(
        private int $id,
        private int $reservationId,
        private PaymentStatus $status,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReservationId(): int
    {
        return $this->reservationId;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }
}
