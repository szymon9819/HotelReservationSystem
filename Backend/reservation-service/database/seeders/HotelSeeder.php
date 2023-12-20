<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

final class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::factory()->count(20)->create();
    }
}
