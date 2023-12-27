<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum\EnumValuesAccessor;

enum ReservationDateFormat: string
{
    use EnumValuesAccessor;

    public const DEFAULT_FORMAT = 'Y-m-d';
}
