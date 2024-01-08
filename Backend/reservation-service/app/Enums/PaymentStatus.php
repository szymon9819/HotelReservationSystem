<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum\EnumValuesAccessor;

enum PaymentStatus: string
{
    use EnumValuesAccessor;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
