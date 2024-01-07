<?php

declare(strict_types=1);

namespace App\Messaging\Entities;

readonly class ReservationCreated
{
    // to update
    private int $userId;

    public function __construct(
        private int $id,
        private float $price,
    ) {
        $this->userId = 1;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
