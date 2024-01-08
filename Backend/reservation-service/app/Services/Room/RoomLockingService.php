<?php

declare(strict_types=1);

namespace App\Services\Room;

use App\Services\DistributedLock\LockingServiceInterface;
use Override;

class RoomLockingService implements RoomLockingServiceInterface
{
    private const int ROOM_LOCK_TTL_IN_SECONDS = 300;

    private const string ROOM_LOCK_KEY_NAME = 'lock:room:reservation';

    public function __construct(
        private readonly LockingServiceInterface $lockingService
    ) {
    }

    public function acquireRoomLock(int $roomId, int $ttlInSeconds = self::ROOM_LOCK_TTL_IN_SECONDS): bool
    {
        return $this->lockingService->acquireLock(self::ROOM_LOCK_KEY_NAME, $roomId, $ttlInSeconds);
    }

    public function releaseRoomLock(int $roomId): void
    {
        $this->lockingService->releaseLock(self::ROOM_LOCK_KEY_NAME, $roomId);
    }

    #[Override]
    public function releaseRoomLockByRoomIds(array $roomIds): void
    {
        $this->lockingService->releaseRoomLockByKeys(self::ROOM_LOCK_KEY_NAME, $roomIds);
    }

    public function checkRoomLockExists(int $roomId): bool
    {
        return $this->lockingService->checkLockExists(self::ROOM_LOCK_KEY_NAME, $roomId);
    }
}
