<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;

class CartItem implements Arrayable
{
    public function __construct(
        private readonly int $itemId,
        private readonly int $quantity
    ) {
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'itemId' => $this->getItemId(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
