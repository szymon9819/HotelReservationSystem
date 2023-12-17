<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum\EnumValuesAccessor;

enum RoomType: string
{
    use EnumValuesAccessor;

    case SINGLE = 'single';
    case DOUBLE = 'double';
    case SUITE = 'suite';
}
