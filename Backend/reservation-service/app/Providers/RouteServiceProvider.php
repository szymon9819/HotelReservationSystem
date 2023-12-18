<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        $this->routes(function (): void {
            Route::middleware('web')->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(
                    base_path('routes/api.php')
                );
        });
    }
}
