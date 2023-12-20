<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1\Hotel;

use App\Models\Hotel;
use Tests\Feature\TestCase;

class EditControllerTest extends TestCase
{
    public function test_show_returns_single_hotel(): void
    {
        $hotel = Hotel::factory()->create();
        $newData = [
            'name' => 'Updated Hotel Name',
            'location' => 'Updated Location',
        ];

        $response = $this->put(route('api.v1.hotels.update', [
            'hotel' => $hotel,
            ...$newData,
        ]));

        $response->assertOk()
            ->assertJsonFragment($newData);
    }

    public function test_show_returns_404_for_non_existing_hotel(): void
    {
        $nonExistingHotelId = 100;

        $response = $this->put(route('api.v1.hotels.update', [
            'hotel' => $nonExistingHotelId
        ]));

        $response->assertNotFound();
    }
}
