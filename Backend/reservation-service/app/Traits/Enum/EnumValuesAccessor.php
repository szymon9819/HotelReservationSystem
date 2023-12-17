<?php

declare(strict_types=1);

namespace App\Traits\Enum;

trait EnumValuesAccessor
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
