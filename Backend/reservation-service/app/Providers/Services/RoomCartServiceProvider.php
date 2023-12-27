<?php

declare(strict_types=1);

namespace App\Providers\Services;

use App\Services\Room\RoomLockingServiceInterface;
use App\Services\RoomCart\RoomCartService;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

final class RoomCartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RoomCartServiceInterface::class, function (): RoomCartService {
            $redisConnection = Redis::connection('default');
            return new RoomCartService($redisConnection, $this->app->make(RoomLockingServiceInterface::class));
        });
    }
}
