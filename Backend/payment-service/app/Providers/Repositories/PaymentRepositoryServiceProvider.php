<?php

declare(strict_types=1);

namespace App\Providers\Repositories;

use App\Repositories\PaymentRepository;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Override;

class PaymentRepositoryServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(PaymentRepositoryInterface::class, PaymentRepository::class);
    }
}
