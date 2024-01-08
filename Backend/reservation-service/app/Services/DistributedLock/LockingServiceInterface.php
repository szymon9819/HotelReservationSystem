<?php

declare(strict_types=1);

namespace App\Services\DistributedLock;

interface LockingServiceInterface
{
    public function acquireLock(string $lockKey, int $elementId, int $ttlInSeconds): bool;

    public function checkLockExists(string $lockKey, int $elementId): bool;

    public function releaseLock(string $lockKey, int $elementId): void;

    public function releaseRoomLockByKeys(string $lockKey, array $keys): void;
}
