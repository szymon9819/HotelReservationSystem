<?php

declare(strict_types=1);

namespace App\Services\Room;

interface RoomLockingServiceInterface
{
    public function acquireRoomLock(int $roomId, int $ttlInSeconds): bool;

    public function releaseRoomLock(int $roomId): void;

    public function releaseRoomLockByRoomIds(array $roomIds): void;

    public function checkRoomLockExists(int $roomId): bool;
}
