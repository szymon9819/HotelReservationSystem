<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;

class CartEntity implements Arrayable
{
    public function __construct(
        private readonly int $customerId,
        private readonly array $items
    ) {
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getItems(): array
    {
        return array_keys($this->items);
    }

    public function toArray(): array
    {
        return [
            'customer_id' => $this->getCustomerId(),
            'items' => $this->getItems(),
        ];
    }
}
