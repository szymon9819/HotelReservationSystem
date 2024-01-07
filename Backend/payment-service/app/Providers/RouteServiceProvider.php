<?php

declare(strict_types=1);

namespace App\Providers;

use Override;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    #[Override]
    public function boot(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(600)->by($request->user()?->id ?: $request->ip()));

        $this->routes(function (): void {
            Route::middleware('web')->group(base_path('routes/web.php'));

            Route::middleware('api')->group(base_path('routes/api.php'));
        });
    }
}
