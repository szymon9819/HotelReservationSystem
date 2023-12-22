<?php

declare(strict_types=1);

namespace App\Contracts\Room;

use Illuminate\Support\Carbon;

interface AvailabilityContract
{
    public function getRoomId(): int;

    public function getStartData(): Carbon;

    public function getEndData(): Carbon;
}
