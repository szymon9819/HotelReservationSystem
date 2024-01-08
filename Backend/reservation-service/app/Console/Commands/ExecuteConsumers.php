<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ExecuteConsumers extends Command
{
    protected $signature = 'rabbitmq:execute-consumers';

    protected $description = 'Execute all consumers commands';

    public function handle(): void
    {
        Artisan::call('payment:consume:successful-payment');
        Artisan::call('payment:consume:failed-payment');
    }
}
