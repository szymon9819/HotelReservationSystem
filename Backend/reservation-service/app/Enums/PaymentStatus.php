<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum\EnumValuesAccessor;

enum PaymentStatus: string
{
    use EnumValuesAccessor;

    case CREATED = 'created';
    case PAID = 'paid';
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
}
