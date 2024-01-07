<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    #[Override]
    public function definition(): array
    {
        return [
            'merchant_id' => random_int(1, 10),
            'reservation_id' => random_int(1, 100),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
