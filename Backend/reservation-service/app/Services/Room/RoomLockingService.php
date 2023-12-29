<?php

declare(strict_types=1);

namespace App\Services\Room;

use App\Services\DistributedLock\LockingServiceInterface;

class RoomLockingService implements RoomLockingServiceInterface
{
    private const ROOM_LOCK_TTL_IN_SECONDS = 300;

    private const ROOM_LOCK_KEY_NAME = 'room:reservation:';

    public function __construct(
        private readonly LockingServiceInterface $lockingService
    ) {
    }

    public function acquireRoomLock(int $roomId, int $ttlInSeconds = self::ROOM_LOCK_TTL_IN_SECONDS): bool
    {
        return $this->lockingService->acquireLock($this->getLockKeyName($roomId), $ttlInSeconds);
    }

    public function releaseRoomLock(int $roomId): void
    {
        $this->lockingService->releaseLock($this->getLockKeyName($roomId));
    }

    public function checkRoomLockExists(int $roomId): bool
    {
        return $this->lockingService->checkLockExists($this->getLockKeyName($roomId));
    }

    private function getLockKeyName(int $roomId): string
    {
        return self::ROOM_LOCK_KEY_NAME . $roomId;
    }
}
