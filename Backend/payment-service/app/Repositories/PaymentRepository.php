<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\PaymentStatus;
use App\Messaging\Entities\ReservationCreated;
use App\Models\Payment;

readonly class PaymentRepository implements PaymentRepositoryInterface
{
    public function __construct(private Payment $entity)
    {
    }

    public function findById(int $id): Payment
    {
        /** @var Payment */
        return $this->entity->query()->findOrFail($id);
    }

    public function createPendingByReservationCreated(ReservationCreated $reservationCreated): Payment
    {
        return $this->entity->create([
            'merchant_id' => $reservationCreated->getUserId(),
            'reservation_id' => $reservationCreated->getId(),
            'amount' => $reservationCreated->getPrice(),
            'status' => PaymentStatus::PENDING,
        ]);
    }

    public function updateStatus(Payment $payment, PaymentStatus $status): Payment
    {
        $payment->status = $status->value;
        $payment->save();

        return $payment;
    }
}
