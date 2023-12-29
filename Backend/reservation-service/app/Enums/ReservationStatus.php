<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum\EnumValuesAccessor;

enum ReservationStatus: string
{
    use EnumValuesAccessor;

    case ACTIVE = 'active';
    case AWAITING_FOR_PAYMENT = 'awaiting_for_payment';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
