<?php

declare(strict_types=1);

namespace App\Messaging\Enums;

enum ExchangeName: string
{
    public const RESERVATION = 'reservation_exchange';

    public const PAYMENT = 'payment_exchange';
}
