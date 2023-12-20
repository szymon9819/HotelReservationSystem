<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1\Hotel;

use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\TestCase;

class CreateControllerTest extends TestCase
{
    public function test_store_creates_new_hotel(): void
    {
        $data = [
            'name' => $this->faker->name,
            'location' => $this->faker->city,
        ];

        $response = $this->post(route('api.v1.hotels.store', $data));

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($data);
    }
}
