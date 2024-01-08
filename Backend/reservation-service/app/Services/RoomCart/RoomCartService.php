<?php

declare(strict_types=1);

namespace App\Services\RoomCart;

use App\Entities\CartEntity;
use App\Exceptions\Room\RoomLockedException;
use App\Services\Room\RoomLockingServiceInterface;
use Illuminate\Redis\Connections\Connection;

class RoomCartService implements RoomCartServiceInterface
{
    public function __construct(
        private readonly Connection $redisConnection,
        private readonly RoomLockingServiceInterface $roomLockingService
    ) {
    }

    /**
     * @throws RoomLockedException
     */
    public function addToCart(int $customerId, int $roomId, int $quantity = 1): void
    {
        if ($this->roomLockingService->checkRoomLockExists($roomId)) {
            throw new RoomLockedException();
        }

        $this->roomLockingService->acquireRoomLock($roomId);

        $this->redisConnection->hIncrBy($this->getCartKey($customerId), $roomId, $quantity);
    }

    public function hasSelectedRooms(int $customerId): bool
    {
        return count($this->redisConnection->hGetAll($this->getCartKey($customerId))) > 0;
    }

    public function removeFromCart(int $customerId, int $roomId): void
    {
        $this->roomLockingService->releaseRoomLock($roomId);

        $this->redisConnection->hDel($this->getCartKey($customerId), $roomId);
    }

    public function getCartEntity(int $customerId): CartEntity
    {
        $cartItems = $this->redisConnection->hGetAll($this->getCartKey($customerId));

        return new CartEntity($customerId, $cartItems);
    }

    public function clearCart(int $customerId): void
    {
        $roomIds = array_keys($this->redisConnection->hGetAll($this->getCartKey($customerId)));

        $this->roomLockingService->releaseRoomLockByRoomIds($roomIds);

        $this->redisConnection->del($this->getCartKey($customerId));
    }

    private function getCartKey(int $customerId): string
    {
        return "room_cart:customer:{$customerId}";
    }
}
