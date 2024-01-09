<?php

declare(strict_types=1);

namespace App\Services\DistributedLock;

use Illuminate\Redis\Connections\Connection;
use Override;

class RedisLockingService implements LockingServiceInterface
{
    public function __construct(
        private readonly Connection $redisConnection
    ) {
    }

    public function acquireLock(string $lockKey, int $elementId, int $ttlInSeconds): bool
    {
        return (bool) $this->redisConnection->sadd($lockKey, $elementId);
    }

    public function checkLockExists(string $lockKey, int $elementId): bool
    {
        return (bool) $this->redisConnection->sismember($lockKey, $elementId);
    }

    public function releaseLock(string $lockKey, int $elementId): void
    {
        $this->redisConnection->srem($lockKey, $elementId);
    }

    #[Override]
    public function releaseRoomLockByKeys(string $lockKey, array $keys): void
    {
        $this->redisConnection->srem($lockKey, ...$keys);
    }
}
