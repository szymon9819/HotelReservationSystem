<?php

declare(strict_types=1);

namespace App\Providers\Services;

use App\Services\Payments\PaymentProcessingService;
use App\Services\Payments\PaymentProcessingServiceInterface;
use Illuminate\Support\ServiceProvider;
use Override;

class PaymentProcessingServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(PaymentProcessingServiceInterface::class, PaymentProcessingService::class);
    }
}
