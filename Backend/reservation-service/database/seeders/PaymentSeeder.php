<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

final class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::factory()->count(300)->create();
    }
}
