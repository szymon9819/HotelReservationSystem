<?php

declare(strict_types=1);

namespace App\Services\Payments;

class RandomNumberGenerator
{
    public function generateRandomNumber(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
