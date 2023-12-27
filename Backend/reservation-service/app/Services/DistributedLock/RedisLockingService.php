<?php

declare(strict_types=1);

namespace App\Services\DistributedLock;

use Illuminate\Redis\Connections\Connection;

class RedisLockingService implements LockingServiceInterface
{
    public function __construct(
        private readonly Connection $redisConnection
    ) {
    }

    public function acquireLock(string $lockKey, int $ttlInSeconds): bool
    {
        $lockValue = uniqid();

        $lockAcquired = $this->redisConnection->setnx($lockKey, $lockValue);

        if ($lockAcquired) {
            $this->redisConnection->expire($lockKey, $ttlInSeconds);
        }

        return (bool) $lockAcquired;
    }

    public function checkLockExists(string $lockKey): bool
    {
        return (bool) $this->redisConnection->exists($lockKey);
    }

    public function releaseLock(string $lockKey): void
    {
        $this->redisConnection->del($lockKey);
    }
}
