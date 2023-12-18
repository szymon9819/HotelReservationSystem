<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1\Hotel;

use App\Models\Hotel;
use Feature\TestCase;

class ShowControllerTest extends TestCase
{
    public function test_show_returns_single_hotel(): void
    {
        $hotel = Hotel::factory()->create();

        $response = $this->get(route('api.v1.hotels.create', [
            'hotel' => $hotel
        ]));

        $response->assertOk()
            ->assertJson([
                'id' => $hotel->id,
                'name' => $hotel->name,
                'location' => $hotel->location,
            ]);
    }

    public function test_show_returns_404_for_non_existing_hotel(): void
    {
        $nonExistingHotelId = 100;

        $response = $this->get(route('api.v1.hotels.create', [
            'hotel' => $nonExistingHotelId
        ]));

        $response->assertNotFound();
    }
}
