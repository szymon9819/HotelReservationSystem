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
        return array_map(
            fn (int $id, int $quantity): CartItem => new CartItem($id, $quantity),
            array_keys($this->items),
            $this->items
        );
    }

    public function toArray(): array
    {
        return [
            'customer_id' => $this->getCustomerId(),
            'items' => array_map(
                fn (CartItem $item): array => $item->toArray(),
                $this->getItems()
            ),
        ];
    }
}
