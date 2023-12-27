<?php

declare(strict_types=1);

namespace App\Services\RoomCart;

use App\Entities\CartEntity;

interface RoomCartServiceInterface
{
    public function addToCart(int $customerId, int $roomId, int $quantity): void;

    public function hasSelectedRooms(int $customerId): bool;

    public function removeFromCart(int $customerId, int $roomId): void;

    public function getCartEntity(int $customerId): CartEntity;

    public function clearCart(int $customerId): void;
}
