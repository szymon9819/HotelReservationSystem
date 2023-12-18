<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CustomerSeeder::class);
        $this->call(HotelSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(ReservationSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}
