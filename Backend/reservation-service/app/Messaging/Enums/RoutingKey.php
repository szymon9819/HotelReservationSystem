<?php

declare(strict_types=1);

namespace App\Messaging\Enums;

enum RoutingKey: string
{
    public const RESERVATION_CREATED = 'reservation_created';

    public const RESERVATION_CANCELLED = 'reservation_cancelled';

    public const PAYMENT_FAILED = 'payment_failed';

    public const PAYMENT_SUCCEEDED = 'payment_succeeded';
}
