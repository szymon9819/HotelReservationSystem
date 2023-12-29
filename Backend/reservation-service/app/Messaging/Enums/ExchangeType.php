<?php

declare(strict_types=1);

namespace App\Messaging\Enums;

enum ExchangeType: string
{
    public const DIRECT = 'direct';
    public const TOPIC = 'topic';
    public const FANOUT = 'fanout';
    public const HEADERS = 'headers';
}
