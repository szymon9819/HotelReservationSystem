<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1\Hotel;

use Feature\TestCase;

class CreateControllerTest extends TestCase
{
    public function test_store_creates_new_hotel(): void
    {
        $data = [
            'name' => $this->faker->name,
            'location' => $this->faker->city,
        ];

        $response = $this->get(route('api.v1.hotels.create', $data));

        $response->assertOk()
            ->assertJsonFragment($data);
    }
}
