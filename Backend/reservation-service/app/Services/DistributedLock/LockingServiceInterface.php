<?php

declare(strict_types=1);

namespace App\Services\DistributedLock;

interface LockingServiceInterface
{
    public function acquireLock(string $lockKey, int $ttlInSeconds): bool;

    public function checkLockExists(string $lockKey): bool;

    public function releaseLock(string $lockKey): void;
}
