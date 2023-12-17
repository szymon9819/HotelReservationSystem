<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RoomType;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'room_type' => $this->faker->randomElement(RoomType::getValues()),
            'price_per_night' => $this->faker->randomFloat(2, 50, 500),
            'availability' => $this->faker->boolean(90),
            'description' => $this->faker->paragraph(),
        ];
    }
}
